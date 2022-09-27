<template>
    <div>
        <div v-if="!loading">
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">Plans</h1>
            </div>
            <div class="card-deck mb-3 text-center d-flex flex row">
                <div class="alert alert-success" v-if="successMessage !== null">
                    <p v-html="successMessage"></p>
                </div>
                <div class="col-md-6" v-for="plan in plans">
                    <div class="card mb-4 box-shadow">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">{{ plan.name }}</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">{{ calculatePeriod(plan.duration) }} {{ plan.price }}</h1>
                            <p>{{ plan.description }}</p>
                            <div
                                v-if="userSubscriptionPlan != null && userSubscriptionPlan.is_subscription_active && userSubscriptionPlan.plan.id == plan.id">
                                <p>This is your current plan, Click on cancel button if you want cancel it.</p>
                                <button @click="cancelSubscription()" type="button" :disabled="loading"
                                        class="btn btn-lg btn-block btn-danger">Cancel
                                </button>
                            </div>
                            <div v-else>
                                <button @click="checkout(plan.id)" type="button" :disabled="loading"
                                        class="btn btn-lg btn-block btn-primary">Subscribe
                                </button>
                            </div>
                        </div>
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
            plans: [],
            userSubscriptionPlan: null,
            successMessage: null
        }
    },
    created() {
        this.loading = true
        this.getPlans()
        this.getUserSubscriptionPlan()
        this.loading = false
    },
    methods: {
        async getPlans() {
            await this.axios.get(api.GET_PLANS)
                .then(res => {
                    this.plans = res.data.data
                })
                .catch((err) => {
                    this.plans = []
                });
        },

        async getUserSubscriptionPlan() {
            await this.axios.get(api.GET_USER_SUBSCRIPTION)
                .then(res => {
                    this.userSubscriptionPlan = res.data.data
                })
                .catch(err => {
                    this.userSubscriptionPlan = null
                })
        },
        async cancelSubscription() {
            await this.axios.post(api.CANCEL_SUBSCRIPTION)
                .then(res => {
                    this.userSubscriptionPlan = null
                    this.successMessage = res.data.message
                    setTimeout(() => {
                        this.successMessage = null
                    }, 5000)
                })
                .catch(err => {
                    this.successMessage = null
                })
        },
        checkout(planId) {
            this.$router.push('/checkout/' + planId)
        },
        calculatePeriod(days) {
            if (days === 30) {
                return 'Monthly'
            }
            if (days === 365) {
                return 'Yearly'
            }
        }
    }
}
</script>
