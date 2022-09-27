<template>
    <div>
        <div class="row" v-if="!loading">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Basic stream analytics</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" v-if="userSubscriptionPlan !== null && userSubscriptionPlan.is_subscription_active">
                    <div class="card-body">
                        <h4>Advance stream analytics</h4>
                    </div>
                </div>
                <div class="card" v-else>
                    <div class="card-body">
                        <p>To see <strong>Advance stream analytics</strong> you need to update your plan</p>
                        <p>
                            <router-link to="/plans">Click here!</router-link>
                            To update your plan
                        </p>
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

export default {
    data() {
        return {
            loading: false,
            userSubscriptionPlan: null
        }
    },
    async created() {
        this.loading = true
        await this.getUserSubscriptionPlan()
        this.loading = false
    },
    methods: {
        async getUserSubscriptionPlan() {
            await this.axios.get(api.GET_USER_SUBSCRIPTION)
                .then(res => {
                    this.userSubscriptionPlan = res.data.data
                })
                .catch(err => {
                    // do stuff
                })
        }
    }
}
</script>
