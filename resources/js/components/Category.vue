<template>
    <div class="row justify-content-center mt-4">
        <div class="col-10 col-lg-8">
            <form action="" @submit.prevent="submitAction">
                <div class="form-group">
                    <label for="category" class="text-info">Category:</label><br>
                    <input type="text" id="category" name="category" class="form-control" placeholder="Category" v-model="category" required>
                </div>
                <div class="form-group">
                    <input v-if="updateCat" type="submit" name="submit" class="btn btn-warning btn-md" value="Update">
                    <button v-on:click="cancel" v-if="updateCat" class="btn btn-danger btn-md">Cancel</button>
                    <input type="submit" name="submit" class="btn btn-success btn-md" value="Create" v-else>
                </div>
            </form>
            <hr>
            <ul class="list-group">
                <li v-for="(category, index) in categories" :key="category.id" class="list-group-item d-flex align-items-center">
                    <i v-on:click="updateCategory(category.slug, index)" class="fas fa-pen text-primary mr-2 icon-style"></i>
                    {{ category.name }} 
                    <i v-on:click="deleteCategory(category.slug, index)" class="far icon-style fa-trash-alt text-danger ml-auto d-block icon-style"></i>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            category: null,
            categories: {},
            updateCat: false,
            tempCat: {}
        }
    },
    created() {
         axios.get('/api/category')
            .then(res => this.categories = res.data.data)
            .catch(error => console.log(error))
    },
    methods: {
        submitAction() {
            if(this.category) {
                if(this.updateCat) {
                    this.updateAction();
                } else {
                    this.creteAction();
                }
            }
        },
        creteAction() {
            axios.post('/api/category', { name: this.category })
                .then(res => this.categories.unshift(res.data))
                .catch(error => console.log(error.response))
        },
        updateAction() {
            axios.put('/api/category/' + this.tempCat.slug, { name: this.category })
                .then(res => {
                    this.categories.unshift(res.data);
                    this.updateCat = false;
                    this.category = null;
                    this.tempCat = null;
                    })
                .catch(error => console.log(error.response))
        },
        deleteCategory(slug, index) {
             axios.delete('/api/category/' + slug)
                    .then(res => this.categories.splice(index,1))
                    .catch(error => console.log(error.response))
        },
        updateCategory(slug, index) {
            this.updateCat = true;
            this.category = this.categories[index].name;
            this.tempCat = this.categories[index];
            this.categories.splice(index,1);
        },
        cancel() {
            this.updateCat = false;
            this.categories.unshift(this.tempCat);
            this.category = null;
            this.tempCat = null;
        }
    }
}
</script>

<style scoped>
    .icon-style {
       cursor: pointer; 
    }
</style>