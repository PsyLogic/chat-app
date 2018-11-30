<template>
    <div class="side-one">
        <me></me>
        <search-box></search-box>

        <div class="row sideBar">
            <div 
                class="row sideBar-body"
                v-for="contact in sortedContacts" 
                :key="contact.id" 
                @click="selectContact(contact)"
                :class="{'selected': selected === contact}"
            >
                <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" :alt="contact.name">
                    </div>
                </div>
                <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 sideBar-name">
                            <span class="name-meta">{{ contact.name }}
                            </span>
                        </div>

                        <div v-if="typing && contact.id == him " class="col-sm-4 col-xs-4 sideBar-time">
                            <span class="help-block" style="font-style: italic; color:#9ddd49;">
                                is typing...
                            </span>
                        </div>
                        
                        <div class="col-sm-2 col-xs-2 sideBar-time pull-right">
                            <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Me from './Me'
    import SearchBox from './SearchBox'
    export default {
        components: {
            SearchBox,
            Me
        },
        props: {
            contacts: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                selected: null,
                typing: false,
                him:null
            }
        },
        mounted() {
            Echo.private('chat')
            .listenForWhisper('typing', (e) => {
                if(User.id === e.receiver) {
                    this.typing = e.typing
                    this.him = e.sender
                }
            });
        },
        methods: {
            selectContact(contact) {
                this.selected = contact
                this.$emit('selectt', contact)
            }
        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if(contact == this.selected) {
                        return -1
                    }
                    return (-contact.unread);
                }])
            }
        },
        

    }
</script>
<style lang="css">
    .selected {
        background-color: #646a80;
    }
</style>