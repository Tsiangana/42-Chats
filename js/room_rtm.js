
    let handleMemberJoined = async (MemberId) => {
        console.log('New member as joined:', MemberId)
        addMemberToDom(MemberId)

        let members = await channel.getMembers()
        updateMemberTotal(members)

        let {name} = await rtmClient.getUserAttributesByKeys(MemberId, ['name'])
        addBotMessageToDom(`Wellcome to the Room ${name}! 😁`)
    }

    let addMemberToDom = async (MemberId) => {
        let {name} = await rtmClient.getUserAttributesByKeys(MemberId, ['name'])

        let membersWrapper = document.getElementById('member__list')
        let memberItem = `<div class="member__wrapper" id="member__${MemberId}__wrapper" style="margin-top: 20px;">
                            <span class="green__icon"></span>
                            <p class="member_name">${name}</p>
                          </div>`

        membersWrapper.insertAdjacentHTML('beforeend', memberItem)
    }

    let updateMemberTotal = async (members) => {
        let total = document.getElementById('members__count')
        total.innerText = members.length
    }

    let handleMemberLeft = async (MemberId) => {
        removeMemberFromDom(MemberId)

        let members = await channel.getMembers()
        updateMemberTotal(members)
    }

    let removeMemberFromDom = async (MemberId) => {
        let memberWrapper = document.getElementById(`member__${MemberId}__wrapper`)
        let name = memberWrapper.getElementsByClassName('member_name')[0].textContent
        memberWrapper.remove()

        addBotMessageToDom(`${name} as left the room 👋🏽`)
    }

    let getMembers = async () =>{
        let members = await channel.getMembers()
        updateMemberTotal(members)

        for (let i = 0; members.length > i; i++) {
            addMemberToDom(members[i])
            
        }
    }

    let handleChannelMessage = async (messageData, MemberId) => {
        console.log('a new message was recieved')
        let data = JSON.parse(messageData.text)
        //console.log('Message:', data)

        if (data.type === 'chat') {
            addMessageToDom(data.displayName, data.message)
        }
    }

    let sendMessage = async (e) =>{
        e.preventDefault()

        let message = e.target.message.value
        channel.sendMessage({text:JSON.stringify({'type':'chat', 'message':message, 'displayName':displayName})})

        addMessageToDom(displayName, message)
        e.target.reset()
    }

    let addMessageToDom = async (name, message) => {
        let messagesWrapper = document.getElementById('messages')

        let newMessage = `<div class="message__wrapper">
                            <div class="message__body">
                                <strong class="message__author">${name}</strong>
                                <p class="message__text">${message}</p>
                            </div>
                          </div>`

        messagesWrapper.insertAdjacentHTML('beforeend', newMessage)

        let lastMessage = document.querySelector('#messages .message__wrapper:last-child')
        if (lastMessage) {
            lastMessage.scrollIntoView()
        }
    }

    let addBotMessageToDom = async (botMessage) => {
        let messagesWrapper = document.getElementById('Welcome_all')

        let newMessage = `<div class="message__wrapper">
                            <div class="message__body__bot">
                                <strong class="message__author__bot">🙋🏽‍♂️ VEchat</strong>
                                <p class="message__text__bot">${botMessage}</p>
                            </div>
                          </div>`

        messagesWrapper.insertAdjacentHTML('beforeend', newMessage)

        let lastMessage = document.querySelector('#messages .message__wrapper:last-child')
        if (lastMessage) {
            lastMessage.scrollIntoView()
        }
    }

    let leaveChannel = async () =>{
        await channel.leave()
        await rtmClient.logout()
    }

    window.addEventListener('beforeunload', leaveChannel)
    let messageForm = document.getElementById('message__form')
    messageForm.addEventListener('submit', sendMessage)