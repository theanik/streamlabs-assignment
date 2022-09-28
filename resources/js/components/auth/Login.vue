<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h1>Login</h1>
                            <form @submit.prevent="login()">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                           aria-describedby="emailHelp" v-model="user.email">
                                    <div id="emailHelp" class="form-text">We'll never share your email with anyone
                                        else.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                           v-model="user.password">
                                </div>
                                <div v-for="error in errors">
                                    <li class="text-danger">{{ error[0] }}</li>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mb-2 w-100">Sign in</button>

                                <div class="text-center">
                                    <p>Not a member?
                                        <router-link to="/register">Register</router-link>
                                    </p>
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
import Auth from '../../utils/Auth.js'
import api from "../../utils/api"
import { eventBus} from "../../app"

export default {
    data() {
        return {
            user: {
                email: '',
                password: '',
            },
            errors: []
        }
    },
    methods: {
        login() {
            this.axios.post(api.USER_LOGIN, this.user)
                .then(res => {
                    let data = res.data.data
                    Auth.login(data.access_token, data.user)
                    this.$router.push("/")
                    eventBus.$emit('loginSuccessAction');
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {}
                    }
                    if (error.response.status === 401) {
                        this.errors = []
                        this.errors = {
                            errorMessage : [error.response.data.message]
                        }
                    }
                })
        }
    }
}
</script>
