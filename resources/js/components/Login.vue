<template>
    <div>
        <div class="row justify-content-center mt-4">
            <div class="col-8 col-lg-6">
                <form action="" @submit.prevent="loginAction">
                    <h3 class="text-center text-primary">Login</h3>
                    <div class="form-group">
                        <label for="Email" class="text-info">Username:</label><br>
                        <input type="text" id="email" name="email" class="form-control" v-model="user.email" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-info">Password:</label><br>
                        <input type="password" id="password" name="password" class="form-control" v-model="user.password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-success btn-md" value="Login">
                        <router-link class="btn btn-primary ml-3" to="/signup">Sign Up</router-link>
                    </div>
                </form>
                <div class="alert alert-danger d-none" id="message" role="alert">Wrong Credential!</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user : {
                    email: null,
                    password: null
                }
            }
        },
        methods: {
           loginAction () {
              if (this.user.email && this.user.password) {                
                axios.post('/api/auth/login', this.user)
                    .then(response => {
                        _User.responseAfterToken(response)
                        // this.$router.push({ path: '/' });
                        window.location = '/';
                    })
                    .catch(function (error) {
                        document.getElementById('message').classList.remove('d-none');
                    });
                    document.getElementById('password').value = '';
    
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