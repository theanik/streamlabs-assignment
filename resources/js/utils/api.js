import config from './config'
export default {
    // Auth Apis
    USER_LOGIN: config.API_URL_ROOT + '/login',
    USER_REGISTER: config.API_URL_ROOT + '/register',
    USER_LOGOUT: config.API_URL_ROOT + '/logout',
    PROFILE: config.API_URL_ROOT + '/profile',
    // Braintree sdk apis
    GET_BRAINTREE_TOKEN: config.API_URL_ROOT + '/braintree-token',
    // Plans apis
    GET_PLANS: config.API_URL_ROOT + '/plans',
    GET_PLAN: config.API_URL_ROOT + '/plan/#ID#',
    // Payment and subscription apis
    CHECKOUT: config.API_URL_ROOT + '/checkout',
    GET_USER_SUBSCRIPTION: config.API_URL_ROOT + '/user-subscription',
    CANCEL_SUBSCRIPTION: config.API_URL_ROOT + '/cancel-subscription'
}
