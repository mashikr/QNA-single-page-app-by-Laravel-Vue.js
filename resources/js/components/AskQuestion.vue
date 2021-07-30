<template>
    <div>
        <div class="row justify-content-center mt-2">
            <div class="col-10 col-lg-8">
                <form action="" @submit.prevent="createAction">
                    <div class="form-group">
                        <label for="title" class="text-info">Title:</label><br>
                        <input type="text" id="title" name="title" class="form-control" v-model="question.title" required>
                    </div>
                    <div class="form-group">
                        <label for="category" class="text-info">Category:</label><br>
                        <select id="category" v-model="question.category_id" class="form-control" required>
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                        </select>
                    </div>

                    <vue-simplemde v-model="question.body" />

                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-success btn-md" value="Create">
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            question: {
                title: null,
                category_id: null,
                body: null
            },
            categories: {}
        }
    },
    created() {
        axios.get('/api/category')
            .then(res => this.categories = res.data.data)
            .catch(err => console.log(err))
    },
    methods: {
        createAction: function () {
            if(this.question.title && this.question.category_id && this.question.body) {
                axios.post('/api/question', this.question)
                    .then(res => this.$router.push({name: 'forum', params: {slug: res.data}}))
                    .catch(err => console.log(err.response))
            }
        }
    }
}
</script>