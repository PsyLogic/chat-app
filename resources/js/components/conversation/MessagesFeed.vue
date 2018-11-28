<template>
    <div class="row message" id="conversation" v-if="contact" ref="conversation">
        <div class="row message-previous">
            <div class="col-sm-12 previous">
                <a onclick="previous(this)" id="ankitjain28" name="20">
                    Show Previous Message!
                </a>
            </div>
        </div>

        <div 
            class="row message-body"
            v-for="message in messages" 
            :key="message.id"    
        >
            <div class="col-sm-12 " :class="`message-main-${message.sender === contact.id ? 'receiver' : 'sender'}`">
                <div :class="`${message.sender === contact.id ? 'receiver' : 'sender'}`">
                    <div class="message-text">
                        {{ message.text }}
                    </div>
                    <!-- <span class="message-time pull-right">
                        Sun
                    </span> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
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
            return {
                messageStatus: ''
            }
        },
        methods: {
            autoScroll () {
                setTimeout(() => {
                    this.$refs.conversation.scrollTop =  this.$refs.conversation.scrollHeight - this.$refs.conversation.clientHeight
                },50)
            }
        },
        watch: {
            contact () {
                this.autoScroll()
            },
            messages () {
                this.autoScroll()
            }
        }
    }
</script>
