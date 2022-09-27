<template>
    <div class="container">
        <!-- Image and text -->
        <nav class="navbar navbar-light bg-light">
            <router-link class="navbar-brand" to="/">
                <img src="https://logos-world.net/wp-content/uploads/2021/04/Streamlabs-Symbol.png" width="60"
                     height="30" class="d-inline-block align-top" alt="">
                Streamlabs
            </router-link>
            <ul class="nav" v-if="loggedUser !== null">
                <li class="nav-item">
                    <router-link to="/plans" class="nav-link">Plans</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/profile" class="nav-link">Profile</router-link>
                </li>
                <li class="nav-item">
                    <button @click="logout" class="btn btn-outline-danger btn-sm mt-1">Logout</button>
                </li>
            </ul>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
import Auth from './utils/Auth.js';
import api from "./utils/api";

export default {
    data() {
        return {
            loggedUser: this.auth.user,
        };
    },
    created() {

    },
    methods: {
        logout() {
            this.axios.post(api.USER_LOGOUT)
                .then(({data}) => {
                    Auth.logout();
                    this.$router.push('/login')
                })
                .catch((error) => {

                });
        }
    }
}
</script>
