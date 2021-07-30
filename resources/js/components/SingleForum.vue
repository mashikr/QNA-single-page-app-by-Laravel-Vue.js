<template>
    <div>
       <div v-if="show">
            <div class="card my-2">
                <div class="card-header bg-secondary text-light">
                    <h4>{{ question.title }}</h4>
                    <small><b>{{ question.user }}</b> said {{ question.created_at }}</small>
                </div>
                <div v-html="body" class="card-body">
                
                </div>
                <div v-if="own" class="card-footer">
                    <router-link :to="{ name: 'forumedit', params: { slug: question.path }}">
                        <i class="far icon-style fa-edit text-info mr-3"></i>
                    </router-link>
                    <i v-on:click="deleteQus" class="far icon-style fa-trash-alt text-danger"></i>
                </div>
                <div class="card-footer bg-secondary text-light">
                    <b>{{ question.replies_count }} reply</b>
                </div>
            </div>
    <hr>
            <replies :replies="question.replies"></replies>

       </div>
        <div v-else>
            <div class="display-4 text-center">Not Found</div>
        </div>
    </div>
</template>
<script>
import md from 'marked';
import Replies from './Replies';
export default {
    data() {
        return {
            question: {body: 'test'},
            show: true,
        }
    },
    created() {
         axios.get('/api/question/'+ this.$route.params.slug)
            .then(res => this.question = res.data.data)
            .catch(error => {
                if(error.response.status){
                    this.show = false;
                }
            })
        EventBus.$on('incReply', () => {
            this.question.replies_count++;
        })

        EventBus.$on('decReply', () => {
            this.question.replies_count--;
        })
    },
    computed: {
        own: function() {
           return _User.own(this.question.user_id);
        },
        body: function() {
            return md.parse(this.question.body);
        }
    },
    methods: {
        deleteQus: function() {
            if(confirm("Are you sure to delete?")) {
                 axios.delete('/api/question/'+ this.$route.params.slug)
                    .then(res => {
                        if(res.data == 'Deleted') {
                            this.$router.push({path: '/'});
                        }
                    })
                    .catch(error => alert(error.response.data.message + ". You should Login again."))
            }
        }
    },
    components: {
        replies: Replies
    }
}
</script>
<style scoped>
    .icon-style {
       font-size: 1.5rem;
       cursor: pointer; 
    }
</style>