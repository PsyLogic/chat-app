<template>
    <div class="feed">
        <ul v-if="contact">
            <li
                v-for="message in messages" 
                :key="message.id" 
                :class="`message ${message.sender === contact.id ? 'sent' : 'received'}`"
            >
                <div class="text">{{ message.text }}</div>
            </li>
        </ul>
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

            }
        },
        mounted() {
        },
    }
</script>
<style lang="scss">
    .feed{
        background-color: #F2F5F8;
        height: 100%;
        max-height: 470px;
        overflow:hidden;
        overflow-y:auto;

        ul{
            padding: 5px;
            list-style-type: none;

            li{
                &.message{
                    margin: 15px 0;
                    line-height: 26px;
                    margin-bottom: 30px;
                    width: 100%;
                    position: relative;

                    .text{
                        display: inline-block;
                        max-width: 70%;
                        font-size: 16px;
                        border-radius: 7px;
                        color: white;
                        padding: 18px 20px;
                    }

                    &:after {
                        bottom: 100%;
                        left: 7%;
                        border: solid transparent;
                        content: " ";
                        height: 0;
                        width: 0;
                        position: absolute;
                        pointer-events: none;
                        border-bottom-color: #86BB71;
                        border-width: 10px;
                        margin-left: -10px;
                    }

                    &.sent{
                        text-align: left;
                        .text{
                            background: #86BB71;
                        }
                        
                    }

                    &.received{
                        text-align: right;
                            &:after {
                                border-bottom-color: #94C2ED;
                                left: 93%;
                            }
                        .text{
                            background: #94C2ED;
                        }
                    }
                }

               
            }
        }
    }
</style>

