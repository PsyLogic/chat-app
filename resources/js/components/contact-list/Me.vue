<template>
    <div class="row heading">
        <div class="col-sm-3 col-xs-3 heading-avatar">
            <div class="heading-avatar-icon">
                <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
            </div>
        </div>
        <div class="col-sm-4 col-xs-4 heading-name">
            <strong>{{ myName }}</strong>
        </div>
        <!-- <div class="col-sm-2 col-xs-2 heading-dot pull-right">
            <a class="dropdown-item" href="/logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out pull-right" aria-hidden="true"></i>
            </a>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <div class="col-sm-2 col-xs-2 heading-compose pull-right">
            <i class="fa fa-user pull-right" aria-hidden="true"></i>
        </div> -->
    </div>
</template>

<script>
    export default {
        data () {
            return {
                myName: ''
            }
        },
        mounted() {
            // until adding VueX to share the authenticated usr widely
            // I'll keep this option for the moment
            this.myName = this.$root.$children[0].$options.propsData.user.name
        },
        methods: {
            logout() {
                axios.post('/logout')
                    .then((resp) => { location.reload() })
            }
        }
    }
</script>