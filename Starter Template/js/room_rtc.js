

const APP_ID = "fb1d6cc2e0fa487e956504dffaed0c00"

let uid = sessionStorage.getItem('uid')

if (!uid) {
    uid = String(Math.floor(Math.random() * 10000))
    sessionStorage.setItem('uid', uid)
}

let token = null;
let client;

const queryString = window.location.search
const urlParams = new URLSearchParams(queryString)

let roomId = urlParams.get('room')

if (!roomId) {
    roomId = 'main'
}

let localTracks = []
let remoteUsers = {}

let joinRoomInit = async () => {
    client = AgoraRTC.createClient({mode:'rtc', codec:'vp8'})
    await client.join(APP_ID, roomId, token, uid)

    handleUserPublished()

    joinStream()
}

let joinStream = async () => {
    localTracks = await AgoraRTC.createMicrophoneAndCameraTracks()

    let player = `<div class="video__container" id="user-container-${uid}">
                    <div class="video-player" id="user-${uid}" ></div>
                  </div>`

    document.getElementById('streams__container').insertAdjacentHTML('beforeend', player)

    localTracks[1].play(`user-${uid}`)
    await client.publish([localTracks[0], localTracks[1]])
}

let handleUserPublished = async (user, mediaType) => {
    
    remoteUsers[user.uid] = user
    alert('deu')

    await client.subscribe(user, mediaType)

    let player = document.getElementById(`user-container-${user.uid}`)

    if (player === null) {

        player = `<div class="video__container" id="user-container-${user.uid}">
                    <div class="video-player" id="user-${user.uid}" ></div>
                  </div>`

        document.getElementById('streams__container').insertAdjacentHTML('beforeend', player)

    }

    if (mediaType === 'video') {
        user.videoTrack.play(`user-${user.uid}`)
    }

    if (mediaType === 'audio') {
        user.audioTrack.play()
    }

    

    
}

joinRoomInit()