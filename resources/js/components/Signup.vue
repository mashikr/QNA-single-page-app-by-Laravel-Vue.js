<template>
    <div>
        <div class="row justify-content-center mt-4">
            <div class="col-8 col-lg-6">
                <form action="" @submit.prevent="signupAction">
                    <h3 class="text-center text-primary">Sign Up</h3>
                    <div class="form-group">
                        <label for="Email" class="text-info">Name:</label><br>
                        <input type="text" id="name" name="name" class="form-control" v-model="user.name" required>
                        <label class="text-danger mb-0" v-if="errors.name">{{ errors.name[0] }}</label>
                    </div>
                    <div class="form-group">
                        <label for="Email" class="text-info">Email:</label><br>
                        <input type="email" id="email" name="email" class="form-control" v-model="user.email" required>
                         <label class="text-danger mb-0" v-if="errors.email">{{ errors.email[0] }}</label>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-info">Password:</label><br>
                        <input type="password" id="password" name="password" class="form-control" v-model="user.password" required>
                         <label class="text-danger mb-0" v-if="errors.password">{{ errors.password[0] }}</label>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="text-info">Confirm Password:</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" v-model="user.confirm_password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Sign Up" class="btn btn-primary">
                        <router-link  class="btn btn-success ml-3"  to="/login">Log In</router-link>
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
                user : {
                    name: null,
                    email: null,
                    password: null,
                    confirm_password: null
                },
                errors: {}
            }
        },
        methods: {
           signupAction () {
              if (this.user.email && this.user.password && this.user.name) {
                   axios.post('/api/auth/signup', this.user)
                        .then(response => {
                            _User.responseAfterToken(response);
                            this.$router.push({ path: '/' });
                            })
                        .catch(error => this.errors = error.response.data.errors);
              }
           }
       },
        created() {
            if(_User.loggedIn()) {
                this.$router.push({ path: '/' });
            }
        }
    }
</script>