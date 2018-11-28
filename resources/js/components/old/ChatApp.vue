<template>
    <div class="chat-app">
        <ContactList  :contacts="contacts" @selectt="startChatWith"/>
        <Conversation :contact="selectedContact" :messages="messages"  />
    </div>
</template>

<script>
import Conversation from './Conversation'
import ContactList from './ContactList'
export default {
    components:{
        Conversation,
        ContactList
    },
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            selectedContact: null,
            contacts: [],
            messages: [],
        }
    },
    mounted () {
        axios.get('/contacts')
            .then(({data}) => { this.contacts = data }) 
    },
    methods: {
        startChatWith(contact){
            axios.get(`/conversation/${contact.id}`)
                .then(({data}) => { this.messages = data; this.selectedContact = contact; })
        }
    }
}
</script>

<style lang="scss" scoped>
.chat-app{
    display: flex;

}
</style>

