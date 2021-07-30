<template>
    <div class="row justify-content-center">
        <div class="col-8 ">
            <div v-for="(reply,index) in replies" :key="index" class="card mb-2">
                <div class="card-header bg-info text-white d-flex justify-content-between">
                    <div><b>{{ reply.user }}</b> said {{ reply.created_at }}</div>
                    <reply-like :reply="reply"></reply-like>
                </div>
                <div class="card-body" v-html="body(reply.reply)">
                </div>
                
                <div v-if="own(reply.user_id)" class="card-footer">
                    <i v-on:click="updateReply(reply.id, index)" class="far icon-style fa-edit text-info mr-3"></i>
                    <i v-on:click="deleteReply(reply.id, index)" class="far icon-style fa-trash-alt text-danger"></i>
                </div>
            </div>
            <div v-if="login">
                <hr>
                <form action="" @submit.prevent="replyAction">
                    <label class="font-weight-bold">Leave a reply: </label>
                    <vue-simplemde v-model="reply" />
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-success btn-md" value="Reply">
                    </div>
                </form>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" @submit.prevent="updateAction">
                            <vue-simplemde v-model="tempReply" :key="tempReply" />
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-success btn-md" value="Update">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import md from 'marked';
import ReplyLike from './ReplyLike';
export default {
    props: ['replies'],
    data() {
        return {
            reply: '',
            tempReply: '',
            tempIndex: null,
            tempId: null
        }
    },
    created() {
        Echo.private('App.Models.User.' + _User.id())
            .notification((notification) => {
                this.replies.unshift(notification.reply);
                EventBus.$emit('incReply', 1);
            });

        Echo.channel('replyDeleteChannel')
            .listen('ReplyDeleteEvent', (e) => {
                for(let index = 0; index < this.replies.length; index++) {
                    if(this.replies[index].id == e.id) {
                        this.replies.splice(index, 1);
                         EventBus.$emit('decReply', 1);
                    }
                }
            });
    },
    methods: {
        own(user_id) {
            return _User.own(user_id);
        },
        replyAction() {
            if(this.reply.trim()) {
                axios.post('/api/question/'+ this.$route.params.slug + '/reply', { body: this.reply })
                    .then(res =>  {
                        this.replies.unshift(res.data);
                        this.reply = '';
                        window.scrollTo(0,0);
                        EventBus.$emit('incReply', 1);
                    })
                    .catch(error => alert(error.response.data.message + ". You should Login again."))
            }
        },
        deleteReply(id, index) {
             if(confirm('Are you sure to delete?')) {
                 axios.delete('/api/question/'+ this.$route.params.slug + '/reply/' + id)
                    .then(res => {
                        this.replies.splice(index, 1);
                        EventBus.$emit('decReply', 1);
                    })
                    .catch(error => alert(error.response.data.message + ". You should Login again."))
             }
        },
        updateReply(id, index) {
            this.tempReply = this.replies[index].reply;
            this.tempIndex = index;
            this.tempId = id;
            $('#exampleModal').modal('show')
        },
        updateAction() {
            if(this.tempReply) {
                axios.put('/api/question/'+ this.$route.params.slug + '/reply/' + this.tempId, { body: this.tempReply })
                    .then(res => {
                        $('#exampleModal').modal('hide')
                        this.replies[this.tempIndex].reply = this.tempReply;
                        this.tempIndex = null;
                        this.tempId = null;
                    })
                    .catch(error => alert(error.response.data.message + ". You should Login again."))
            }
        },
        body(body) {
            return md.parse(body);
        }
    },
    computed: {
        login: function() {
            return _User.loggedIn();
        }
    },
    components: {
        ReplyLike: ReplyLike
    }
}
</script>
<style>
    .icon-style {
        font-size: 1.3rem;
       cursor: pointer; 
    }
</style>