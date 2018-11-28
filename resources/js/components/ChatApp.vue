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
                    })
            },
            newMessage(message) {
                this.messages.push(message);
            },
            handelIncomingMessage(message) {
                // console.log(this.selectedContact)
                if(this.selectedContact && message.sender == this.selectedContact.id ) {
                    this.newMessage(message)
                }else{
                    console.log("Got from an other Sender", message)
                }

            },
            updateUnreadCount() {
                if(this.selectedContact) {
                    axios.post('/conversation/update-unread-messages',{sender: this.user.id, reveiver: this.selectedContact.id})
                        .then((response) => {console.log(response.data)})
                }
            }

        }
    }

</script>