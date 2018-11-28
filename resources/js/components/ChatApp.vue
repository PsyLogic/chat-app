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
        name: 'chat-app',
        components: {
            Conversation,
            ContactList
        },
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                selectedContact: null,
                contacts: [],
                messages: [],
            }
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    console.log(e)
                    this.handelIncomingMessage(e.message)
                })
            axios.get('/contacts')
                .then(({
                    data
                }) => {
                    this.contacts = data
                })
        },
        methods: {
            startChatWith(contact) {

                axios.get(`/conversation/${contact.id}`)
                    .then(({
                        data
                    }) => {
                        this.messages = data;
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
                    this.contacts[findContact].unread = reset
                    axios.post('/conversation/update-unread-messages',{id_sender: idContact})
                        .then((response) => {console.log(response.data)})
                }
            }

        }
    }

</script>