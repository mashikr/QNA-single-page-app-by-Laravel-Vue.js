<template>
    <div class="row justify-content-center mt-2">
            <div class="col-10 col-lg-8">
                <form action="" @submit.prevent="updateAction">
                    <div class="form-group">
                        <label for="title" class="text-info">Title:</label><br>
                        <input type="text" id="title" name="title" class="form-control" v-model="question.title" required>
                    </div>

                    <vue-simplemde v-model="question.body" />

                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-success btn-md" value="Update">
                    </div>
                </form>
            </div>
        </div>
</template>
<script>
export default {
    data() {
        return {
            question: {
                title: null,
                body: null
            }
        }
    },
    created() {
         axios.get('/api/question/'+ this.$route.params.slug)
            .then(res => this.question = res.data.data)
            .catch(error => console.log(error.response))
    },
    methods: {
        updateAction() {
            if(this.question.title && this.question.body) {
                axios.put('/api/question/'+ this.$route.params.slug, {title: this.question.title, body: this.question.body})
                   .then(res => {
                       if(res.data == 'Updated') {
                           this.$router.push({ name: 'forum', params: { slug: this.question.path }});
                       }
                   })
                   .catch(error => alert(error.response.data.message + ". You should Login again."))
            }
        }
    }
}
</script>