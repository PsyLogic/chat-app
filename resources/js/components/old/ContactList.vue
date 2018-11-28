<template>
    <div class="contact-list">
        <ul>
            <li
                v-for="(contact, index) in contacts" 
                :key="contact.id" 
                @click="selectContact(contact, index)"
                :class="{'selected': selected === index}"
                > 
                <div class="avatar">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01.jpg" :alt="contact.name">
                </div>
                <div class="contact">
                    <p class="name">{{ contact.name }}</p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            contacts: {
                type: Array,
                default: []
            }
        },
        data () {
            return {
                selected: 0
            }
        },
        methods: {
            selectContact(contact, index) {
                this.selected = index
                this.$emit('selectt', contact)
            }
        },

    }
</script>

<style lang="scss">
.contact-list{
    flex: 2;
    max-height: 600px;
    overflow:hidden;
    overflow-y:auto;
    border-right: 1px solid #ccc;
    background-color: #444753;
    color: #fff;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    ul{
        list-style-type: none;
        padding-left:0px;

        li{
            display: flex;
            padding: 2px;
            height: 70px;
            position: relative;
            cursor: pointer;
            border-bottom: 1px solid #575757;

            &.selected{
                background-color: #9094a2;
            }

            .avatar{
                flex:1;
                display: flex;
                align-items: center;

                img{
                    width: 40px;
                    border-radius: 50%;
                    margin: 0 auto;
                }
            }
            .contact{
                flex:3;
                font-size: 13px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                .name{
                    margin: 0;
                    font-weight: bold;
                }
            }
        }

        
    }
}
</style>