<template>
    <div class="composer">
        <textarea class="" v-model="message" placeholder="type Message..." @keydown="sendMessage"></textarea>
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
            sendMessage() {
                if(this.message !== ''){
                    return
                }
                this.$emit('send', this.message)
                this.message = ''            
            }
        }
    }
</script>
<style lang="scss">
    .composer textarea{
        width: 96%;
        margin: 10px;
        resize: none;
        border-radius: 3px;
        border: 1px solid #ccc;
        padding: 6px;
    }
</style>

