<template>
    <div>
        <div class="row" v-if="!loading">
            <div class="card">
                <div class="card-body">
                    <h4>Hi, {{ user.name }}</h4>
                    <p>Email : {{ user.email }}</p>
                </div>
            </div>
            <div class="card  mt-2">
                <div class="card-header">
                    Subscription Information
                </div>
                <div class="card-body">
                    <div v-if="user.subscription">
                        <p>Plan : {{ user.subscription.plan.name }}</p>
                        <p v-if="user.subscription.cancelled">Cancelled At : {{ user.subscription.cancelled_at }}</p>
                        <p v-else>Expiry Date : {{ user.subscription.expiry_date }}
                            <small v-if="getLeftDays(user.subscription.expiry_date) > 0">({{ getLeftDays(user.subscription.expiry_date) }} days left)</small>
                            <small v-else>(Expired)</small>
                        </p>
                    </div>
                    <div v-else>
                        You did not subscribed any plan, <router-link to="/plans">Click here!</router-link> to subscribed
                    </div>
                </div>
            </div>

        </div>
        <div v-else class="d-flex justify-content-center mt-5">
            <div class="spinner-border text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</template>
<script>
import api from "../../utils/api";
import { dateDiffInDays } from '../../utils/helpers'
export default {
    data () {
        return {
            loading: false,
            user: null
        }
    },
    async created() {
        this.loading = true
        await this.getCurrentUser()
        this.loading = false
    },
    methods: {
        async getCurrentUser() {
            await this.axios.get(api.PROFILE)
                .then(res => {
                    this.user = res.data.data
                })
                .catch(err => {

                })
        },
        getLeftDays(date) {
            return dateDiffInDays(new Date(date),new Date())
        }
    }
}
</script>
