<template>
    <div class="container bg-white">
        
        <nav class="navbar navbar-dark bg-primary">
            <router-link class="navbar-brand" to="/">QusAns App</router-link>
            
            <ul class="navbar-nav flex-row ml-auto">
                <notification v-if="login"></notification>

                <li class="nav-item mr-3">
                    <router-link to="/" class="nav-link">Forum</router-link>
                </li>

                <li class="nav-item mr-3">
                    <router-link to="/ask" class="nav-link" v-if="login">Ask Question</router-link>
                </li>
            
                <li class="nav-item mr-3" v-if="login">
                    <router-link to="/category" class="nav-link">Category</router-link>
                </li>      

                <li class="nav-item" v-if="!login">
                    <router-link to="/login" class="nav-link">Login</router-link>
                </li>        

                <li class="nav-item" v-if="login">
                    <router-link to="/logout" class="nav-link">Logout</router-link>
                </li>        
                
            </ul>
        </nav>
        
        <router-view></router-view>

        <div class="p-3 text-center bg-light mt-3">
            QusAns app @2021
        </div>
    </div>
</template>

<script>
import Notification from './Notification';
    export default {
       data(){
           return {
              // login: _User.loggedIn()
           }
       },
       computed: {
           login: function () {
              return _User.loggedIn();
           }
       },
       components: {
           notification: Notification
       }
    }
</script>
