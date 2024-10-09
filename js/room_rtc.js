

const APP_ID = "fb1d6cc2e0fa487e956504dffaed0c00"

let uid = sessionStorage.getItem('uid')

if (!uid) {
    uid = String(Math.floor(Math.random() * 10000))
    sessionStorage.setItem('uid', uid)
}

let token = null;
let client;

let rtmClient;
let channel;

const queryString = window.location.search
const urlParams = new URLSearchParams(queryString)

let roomId = urlParams.get('room')

if (!roomId) {
    roomId = 'main'
}

let displayName = sessionStorage.getItem('display_name')
if (!displayName) {
    window.location = 'lobby.html'
}

let localTracks = []
let remoteUsers = {}

let localScreenTracks;
let sharingScreen = false;

let joinRoomInit = async () => {

    rtmClient = await AgoraRTM.createInstance(APP_ID)
    await rtmClient.login({uid,token})

    await rtmClient.addOrUpdateLocalUserAttributes({'name':displayName})

    channel = await rtmClient.createChannel(roomId)
    await channel.join()

    channel.on('MemberJoined', handleMemberJoined)
    channel.on('MemberLeft', handleMemberLeft)
    channel.on('ChannelMessage', handleChannelMessage)

    getMembers()
    addBotMessageToDom(`Wellcome to the Room ${displayName}! 😁`)

    client = AgoraRTC.createClient({mode:'rtc', codec:'vp8'})
    await client.join(APP_ID, roomId, token, uid)

    client.on('user-published', handleUserPublished)
    client.on('user-left', handleUserLeft)

    //joinStream()
}

let joinStream = async () => {
    //document.getElementById('join-btn').style.display = 'none'
    //document.getElementsByClassName('main_icons')[0].style.display = 'flex'

    localTracks = await AgoraRTC.createMicrophoneAndCameraTracks({}, {encoderConfig:{
        width:{min:640, ideal:1920, max:1920},
        height:{min:480, ideal:1080, max:1080}
    }})

    let player = `<div class="video_container" id="user-container-${uid}">
                    <div class="video-player" id="user-${uid}" ></div>
                  </div>`

    document.getElementById('streams_container').insertAdjacentHTML('beforeend', player)
    document.getElementById(`user-container-${uid}`).addEventListener('click', expandVideoFrame)

    localTracks[1].play(`user-${uid}`)
    await client.publish([localTracks[0], localTracks[1]])

}


let switchToCamera = async () =>{
    let player = `<div class="video_container" id="user-container-${uid}">
                    <div class="video-player" id="user-${uid}"></div>
                  </div>`

    displayFrame.insertAdjacentHTML('beforeend', player)

    await localTracks[0].setMuted(true)
    await localTracks[1].setMuted(true)

    document.getElementById('mic-btn').classList.remove('active')
    document.getElementById('screen-btn').classList.remove('active')

    localTracks[1].play(`user-${uid}`)
    await client.publish([localTracks[1]])
}

let handleUserPublished = async (user, mediaType) => {
    remoteUsers[user.uid] = user

    await client.subscribe(user, mediaType)

    let player = document.getElementById(`user-container-${user.uid}`)

    if (player === null) {

        player = `<div class="video_container" id="user-container-${user.uid}">
                    <div class="video-player" id="user-${user.uid}" ></div>
                  </div>`

        document.getElementById('streams_container').insertAdjacentHTML('beforeend', player)
        document.getElementById(`user-container-${user.uid}`).addEventListener('click', expandVideoFrame)
    }
    if (displayFrame.style.display) {
        let videoFrame = document.getElementById(`user-container-${user.uid}`)
        videoFrame.style.height = '100px'
        videoFrame.style.width = '100px'
    }

    if (mediaType === 'video') {
        user.videoTrack.play(`user-${user.uid}`)
    }

    if (mediaType === 'audio') {
        user.audioTrack.play()
    }   
    
}

let handleUserLeft = async (user) => {

    delete remoteUsers[user.uid]
    document.getElementById(`user-container-${user.uid}`).remove()

    if (userIdInDisplayFrame === `user-container-${user.uid}`) {
        displayFrame.style.display = null;

        let videoFrames = document.getElementsByClassName('video_container');
        for (let i = 0; videoFrames.length > i; i++) {
            videoFrames[i].style.height = '250px'
            videoFrames[i].style.width = '250px'
            
        }
    }
}

let toggleMic = async (e) => {
    let button = e.currentTarget

    if (localTracks[0].muted) {
        await localTracks[0].setMuted(false)
        button.classList.add('active')
    }else{
        await localTracks[0].setMuted(true)
        button.classList.remove('active')
    }
}

let toggleCamera = async (e) => {
    let button = e.currentTarget

    if (localTracks[1].muted) {
        await localTracks[1].setMuted(false)
        button.classList.add('active')
    }else{
        await localTracks[1].setMuted(true)
        button.classList.remove('active')
    }
}

let toggleScreen = async (e) =>{
    let screenButton = e.currentTarget
    let cameraButton = document.getElementById('camera-btn')
    let part = document.getElementById('part')

    if (!sharingScreen) {
        sharingScreen = true

        screenButton.classList.remove('active')
        part.style.display = 'none'

        localScreenTracks = await AgoraRTC.createScreenVideoTrack()

        document.getElementById(`user-container-${uid}`).remove()
        displayFrame.style.display = 'block'
        cameraButton.classList.remove('active')

        let player = `<div class="video_container" id="user-container-${uid}">
                    <div class="video-player" id="user-${uid}" ></div>
                  </div>`

        displayFrame.insertAdjacentHTML('beforeend', player)
        document.getElementById(`user-container-${uid}`).addEventListener('click', expandVideoFrame)

        userIdInDisplayFrame = `user-container-${uid}`
        localScreenTracks.play(`user-${uid}`)

        await client.unpublish([localTracks[1]])
        await client.publish([localScreenTracks])

        let videoFrames = document.getElementsByClassName('video_container')
        for (let i = 0; videoFrames.length > i; i++) {
            videoFrames[i].style.height = '250px'
            videoFrames[i].style.width = '250px'
          }

    }else{
        sharingScreen = false
        part.style.display = 'block'
        //screenButton.classList.add('active')
        //cameraButton.classList.add('active')

        document.getElementById(`user-container-${uid}`).remove()
        await client.unpublish([localScreenTracks])

        switchToCamera()
    }
}

let leaveStream = async (e) => {
    e.preventDefault()

    for (let i = 0; localTracks.length > 0; i++) {
        localTracks[i].stop()
        localTracks[i].close()
    }

    await client.unpublish([localTracks[0], localTracks[1]])

    if (localScreenTracks) {
        await client.unpublish([localScreenTracks])
    }

    document.getElementById(`user-container-${uid}`).remove()

    if (userIdInDisplayFrame === `user-container-${uid}`) {
        displayFrame.style.display = null

        for (let i = 0; videoFrames.length > i; i++) {
            videoFrames[i].style.height = '250px'
            videoFrames[i].style.width = '250px'
          }
    }
}

document.getElementById('camera-btn').addEventListener('click', toggleCamera)
document.getElementById('mic-btn').addEventListener('click', toggleMic)
document.getElementById('screen-btn').addEventListener('click', toggleScreen)
document.getElementById('join-btn').addEventListener('click', joinStream)
document.getElementById('leave-btn').addEventListener('click', leaveStream)

joinRoomInit()