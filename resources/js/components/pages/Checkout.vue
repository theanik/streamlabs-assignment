<template>
    <div>
        <div v-if="!loading">
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">{{ plan.name }}</h1>
                <p>{{ plan.description }}</p>
                <h1 class="card-title pricing-card-title">{{ calculatePeriod(plan.duration) }} {{ plan.price }}</h1>
            </div>
            <div id="show_success_message" class="d-none">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Congratulations! <small></small></h4>
                    <p>Aww yeah, You have successfully created your {{ plan.name }} plan
                    <hr>
                    <p>
                        <router-link to="/">Click Here!</router-link> to view the dashboard
                    </p>
                </div>
            </div>
            <div id="payment_submit_loader" class="d-none">
                <div class="d-flex justify-content-center mt-5">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div>
                <div id="dropin-container"></div>
                <input id="nonce" name="payment_method_nonce" type="hidden"/>
                <input id="planId" name="planId" v-model="plan.id" type="hidden"/>
                <p id="show_error_message" class="d-done text-danger"></p>
                <button id="submit-button" class="btn btn-outline-success">Purchase</button>
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
import axios from 'axios'

export default {
    data() {
        return {
            plan: null,
            braintree_token: '',
            loading: false
        }
    },
    async mounted() {
        this.loading = true
        await this.getPlan()
        if (localStorage.getItem('braintree_token') === null || localStorage.getItem("braintree_token") === 'undefined') {
            await this.getBraintreeToken()
        } else {
            this.braintree_token = localStorage.getItem('braintree_token')
        }

        braintree.dropin.create({
            authorization: this.braintree_token,
            selector: '#dropin-container',
            paypal: {
                flow: 'vault'
            }
        }, function (err, instance) {
            let button = document.querySelector('#submit-button');
            button.addEventListener('click', function () {
                button.setAttribute("disabled", 'disabled');
                document.querySelector('#show_error_message').classList.add('d-none')
                document.querySelector('#show_success_message').classList.add('d-none')
                document.querySelector('#payment_submit_loader').classList.remove('d-none')
                instance.requestPaymentMethod(async function (err, payload) {
                    let planId = document.querySelector('#planId').value
                    await axios.post(api.CHECKOUT, {planId, nonce: payload?.nonce})
                        .then(res => {
                            document.querySelector('#show_success_message').classList.remove('d-none')
                            document.querySelector('#show_success_message small').innerHTML = res.data.message
                            button.classList.add('d-none')
                        }).catch(err => {
                            document.querySelector('#show_error_message').classList.remove('d-none')
                            document.querySelector('#show_error_message').innerHTML = err.response.data.message

                            setTimeout(() => {
                                document.querySelector('#show_error_message').classList.add('d-none')
                            }, 5000)
                        }).finally(() => {
                            document.querySelector('#payment_submit_loader').classList.add('d-none')
                            button.removeAttribute("disabled");
                        })
                });
            })
        });
        this.loading = false
    },
    methods: {
        async getPlan() {
            let url = api.GET_PLAN
            url = url.replace('#ID#', this.$route.params.id)
            await this.axios.get(url)
                .then(res => {
                    this.plan = res.data.data
                })
                .catch(err => {
                    this.plan = null
                });
        },
        async getBraintreeToken() {
            await this.axios.get(api.GET_BRAINTREE_TOKEN)
                .then(res => {
                    this.braintree_token = res.data.data.braintree_token
                    localStorage.setItem('braintree_token', res.data.data.braintree_token)
                })
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
