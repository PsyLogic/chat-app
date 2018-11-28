<template>
    <div v-if="contact">
        <head-chat :contact="contact"></head-chat>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
    </div>
    <no-chat v-else></no-chat>
</template>

<script>
    import HeadChat from './HeadChat'
    import NoChat from './NoChat'
    import MessagesFeed from './MessagesFeed'
    import MessageComposer from './MessageComposer'
    export default {
        components: {
            HeadChat,
            NoChat,
            MessagesFeed,
            MessageComposer
        },
        props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            }
        },
        data() {
            return {}
        },
        methods: {
            sendMessage(messageText) {
                if(this.contact){
                    let data = {
                        receiver_id: this.contact.id,
                        message: messageText
                    }
                    axios.post('/message/send',data)
                        .then((response) => { 
                            this.$emit('new-message', response.data)
                         })
                }
            }
        }
    }

</script>