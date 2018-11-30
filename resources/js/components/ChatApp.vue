<template>
    <div class="container app">
        <div class="row app-one">
            <div class="col-sm-4 side">
                <ContactList  :contacts="contacts" @selectt="startChatWith"/>
            </div>
            <div class="col-sm-8 conversation">
                <Conversation :contact="selectedContact" :messages="messages" @new-message="newMessage"  />
            </div>
        </div>
    </div>
</template>

<script>
    import Conversation from './conversation/Conversation'
    import ContactList from './contact-list/ContactList'
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        components: {
            Conversation,
            ContactList
        },
        data() {
            return {
                selectedContact: null,
                contacts: [],
                messages: [],
                permerssion: ''
            }
        },
        mounted() {
            this.getNotificationPermissions()
            // Listen to incoming messages
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.notifyUser(e.message)
                    this.handelIncomingMessage(e.message)
                })
            // Get All Contacts
            this.getAllContacts()
        },
        methods: {
            getAllContacts() {
                axios.get('/contacts')
                .then(({
                    data
                }) => {
                    this.contacts = data
                })
            },
            startChatWith(contact) {

                axios.get(`/conversation/${contact.id}`)
                    .then(({data}) => {
                        this.messages = data.reverse();
                        this.selectedContact = contact;
                        this.updateUnreadCount(contact.id)
                    })

                
            },
            newMessage(message) {
                this.messages.push(message);
            },
            handelIncomingMessage(message) {

                if(this.selectedContact && message.sender == this.selectedContact.id ) {
                    this.newMessage(message)
                }else{
                    this.updateUnreadCount(message.sender, true)
                }

            },
            updateUnreadCount(idContact,reset = 0) {
                let findContact = _.findIndex(this.contacts,{'id': idContact})
                if(reset) {
                    this.contacts[findContact].unread += 1
                }else {
                    if(this.contacts[findContact].unread){
                        this.contacts[findContact].unread = reset
                        axios.post('/conversation/update-unread-messages',{id_sender: idContact})
                            .then((response) => { /*console.log(response.data)*/})
                    }
                }
            },
            getNotificationPermissions() {
                if(!( 'Notification' in window )) {
                    alert('web Notification is not supported')
                    return
                }

                Notification.requestPermission((permerssion) => {
                    this.permerssion = permerssion
                })
            },
            notifyUser (message) {
                if(this.permerssion === 'granted') {
                    let notification = new Notification('New Message From: : '+ message.user.name, {
                        body: message.text,                    
                        icon: 'https://d1nhio0ox7pgb.cloudfront.net/_img/o_collection_png/green_dark_grey/256x256/plain/message.png'
                    })
                    notification.onclick = function(e){
                        e.preventDefault()
                        window.focus()
                        this.close()
                    }

                }
            }

        }
    }

</script>