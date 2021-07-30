<template>
    <li class="nav-item dropdown mr-2">
        <a class="nav-link dropdown-toggle" :class="{ 'text-warning': unReadCount }" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell"></i> {{ unReadCount }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <router-link v-for="item in unread" :key="item.id" class="dropdown-item" :to="'/forum/' + item.path"><span @click="readIt(item)"><b>{{ item.replyBy }}</b> reply on <i>"{{ item.question }}"</i> question</span></router-link>
        </div>
    </li>
</template>
<script>
export default {
    data() {
        return {
            read: {},
            unread: {},
            unReadCount: 0,
            sound: "https://notificationsounds.com/storage/sounds/file-sounds-1155-got-it-done.mp3"
        }
    },
    created() {
        if(_User.loggedIn()) {
            this.getNotifications();
        }

        Echo.private('App.Models.User.' + _User.id())
            .notification((notification) => {
                this.playTune()
                this.unread.unshift(notification);
                this.unReadCount++;
            });
    },
    methods: {
        playTune() {
            let alert = new Audio(this.sound);
            alert.play();
        },
        getNotifications() {
            axios.post('/api/notifications')
                .then(res =>  {
                    this.read = res.data.read;
                    this.unread = res.data.unread;
                    if(res.data.unread) {
                        this.unReadCount = res.data.unread.length;
                    }
                })
                .catch(err => _Exception.isExpired(err.response.data.message))
                
        },
        readIt(notification) {
            axios.post('/api/markAsRead', { id: notification.id })
            .then(res => {
                this.unread.splice(notification, 1);
                this.read.push(notification)
                this.unReadCount--;
            })
            .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.navbar-nav .dropdown-menu {
    position: absolute !important;
}
</style>