<template>
    <div class="row">
        <div class="col-md-8">
            <forum-item v-for="(question, index) in questions" :key="index" :question="question">
            </forum-item>

            <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
                <ul class="pagination">
                    <li class="page-item" :class="[ data.current_page == 1 ? 'disabled': '' ]">
                    <a class="page-link" @click="prevPage()" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>

                    <li v-for="i in data.last_page" :key=i class="page-item" :class="[ i == data.current_page ? 'active': '' ]"><a class="page-link" @click="paginateQus(i)">{{ i }}</a></li>

                    <li class="page-item" :class="[ data.current_page == data.last_page ? 'disabled': '' ]">
                    <a class="page-link" @click="nextPage()" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                </ul>
            </nav>

        </div>
        <div class="col-md-4">
            <div class="card mt-2">
                <div class="card-header">
                    <h3>Categories</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li v-for="category in categories" :key="category.id" class="list-group-item">{{ category.name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ForumItem from './ForumItem';
export default {
    data() {
       return {
           questions: {},
           categories: {},
           data: {}
       } 
    },
    created() {
        this.fetchQuestion();
        
        axios.get('/api/category')
            .then(res => this.categories = res.data.data)
            .catch(error => console.log(error))
    },
    components: {
        ForumItem: ForumItem
    },
    methods:{
        fetchQuestion(page) {
            let url = '/api/question';
            page ? url = url + '?page=' + page : url;
            axios.get(url)
            .then(res => {
                this.questions = res.data.data
                this.data = res.data.meta
            })
            .catch(error => console.log(error))
        },
        paginateQus(page) {
            this.fetchQuestion(page);
        },
        prevPage() {
            this.fetchQuestion(this.data.current_page - 1);
        },
        nextPage() {
           this.fetchQuestion(this.data.current_page + 1);
        }
    }
}
</script>

<style scoped>
.page-item {
    cursor: pointer;
}
</style>