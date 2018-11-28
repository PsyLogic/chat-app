<template>
    <div class="conversation">
        <h1> {{ contact ? contact.name : 'Select a Contact ' }}</h1>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
    </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed'
    import MessageComposer from './MessageComposer'
    export default {
        components: {
            MessagesFeed, MessageComposer
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
        data () {
            return {}
        },
        methods: {
            sendMessage(messageText) {
                console.log(messageText)
            }
        }
    }
</script>

<style lang="scss">
    .conversation{
        flex:5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;

        h1{
            font-size: 20px;
            padding: 10px;
            margin: 0;
            border-bottom: 2px solid #444;
            background-color: #e2e2e2;
        }
    }
</style>
