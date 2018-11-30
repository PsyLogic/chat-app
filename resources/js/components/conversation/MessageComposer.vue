<template>
    <div class="row reply">
        <div class="col-sm-1 col-xs-1 reply-emojis">
            <i class="fa fa-smile-o fa-2x"></i>
        </div>
        <div class="col-sm-10 col-xs-11 reply-main">
            <textarea class="form-control" id="comment" v-model="message" placeholder="type Message..."  @keyup="isTyping" @keydown.enter="sendMessage"></textarea>
        </div>
        <div class="col-sm-1 col-xs-1 reply-send">
            <i class="fa fa-send fa-2x" aria-hidden="true"></i>
        </div> 
    </div>
</template>
<script>
    export default {
        data () {
            return {
                message: ''
            }
        },
        methods: {
            sendMessage(e) {
                e.preventDefault();
                
                if(this.message === ''){
                    return
                }
                this.$emit('send', this.message)
                this.message = ''            
            },
            isTyping() {
                let typing = true
                if(this.message === ''){
                    typing=false
                }
                Echo.private('chat')
                .whisper('typing', {
                    sender: User.id,
                    receiver: this.$parent.contact.id,
                    typing: typing
                })
            }
        }
    }
</script>
