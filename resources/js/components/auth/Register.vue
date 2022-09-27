<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h1>Register</h1>
                            <form @submit.prevent="register()">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" v-model="user.name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                           v-model="user.email">
                                    <div id="emailHelp" class="form-text">We'll never share your email with anyone
                                        else.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" v-model="user.password">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                           v-model="user.password_confirmation">
                                </div>
                                <div v-for="error in errors">
                                    <ul class="">
                                        <li class="text-danger">{{ error[0] }}</li>
                                    </ul>

                                </div>
                                <div v-if="registerSuccess">
                                    <p><span class="text-success">Registration successfully done!</span>
                                        <router-link to="/login">Click here</router-link>
                                        to login
                                    </p>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mb-2 w-100">Register</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import api from "../../utils/api";

export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: [],
            registerSuccess: false
        };
    },
    methods: {
        register() {
            this.axios.post(api.USER_REGISTER, this.user)
                .then(res => {
                    if (res.status === 201) {
                        this.registerSuccess = res
                        this.resetData()
                    }
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {}
                    }
                })
        },
        resetData() {
            this.user = {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        }
    }
}
</script>
