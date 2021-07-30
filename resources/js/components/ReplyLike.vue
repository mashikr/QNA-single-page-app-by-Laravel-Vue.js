<template>
    <div class="btn text-white">
        <i @click="likeIt" class="fas fa-heart icon-style" :class="{ 'text-danger' : liked }"></i> {{ count }}
    </div>
</template>

<script>
export default {
    props: ['reply'],
    data() {
        return {
            liked: this.reply.liked,
            count: this.reply.like_count
        }
    },
    created() {
        Echo.channel('likeChannel')
            .listen('LikeEvent', (e) => {
                if(this.reply.id == e.id) {
                    e.type == 1? this.count++ : this.count--;
                }
            });
    },
    methods: {
        likeIt() {
            if(_User.loggedIn()) {
                this.liked ? this.decr() : this.incr();
            }
        },
        incr() {
            axios.post('/api/like/' + this.reply.id)
                .then(res => {
                    this.count++;
                    this.liked = !this.liked;
                })
                .catch(error => alert(error.response.data.message + ". You should Login again."))
        },
        decr() {
            axios.delete('/api/like/' + this.reply.id)
                .then(res => {
                    this.count--;
                    this.liked = !this.liked;
                })
                .catch(error => alert(error.response.data.message + ". You should Login again."))
        }
    }
}
</script>

<style>
    .icon-style {
        font-size: 1.3rem;
    }
</style>