<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"
               v-for="notification in notifications"
               :href="notification.data.link"
               @click="markAsRead(notification)"
            >{{ notification.data.message}}</a>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: false
            }
        },
        created(){
            axios.get('/profiles/'+ window.App.user.name +'/notifications').then(response=>{
                this.notifications = response.data;
            });
        },
        methods:{
            markAsRead(notification){
                axios.delete('/profiles/'+ window.App.user.id + '/notifications/' + notification.id)
            }
        }
    }
</script>

