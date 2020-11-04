import axios from 'axios';
import Vue from 'vue';
import store from "store/store";
import join from 'url-join';
import finallyBlock from 'promise.prototype.finally'

finallyBlock.shim();

let isAbsoluteURLRegex = /^(?:\w+:)\/\//;

axios.interceptors.request.use((config) => {
    // Concatenate base path if not an absolute URL
    if ( !isAbsoluteURLRegex.test(config.url) ) {
        config.url = join(process.env.MIX_APP_URL, config.url);
    }

    config.headers['Content-Type'] = "application/json";
    config.headers['Accept'] = "application/json";
    config.headers['Accept-Language'] = Vue.prototype.$cookies.language || 'en'

    if(Vue.$jwt.hasToken()) {
        config.headers['Authorization'] = "Bearer " + Vue.$jwt.getToken();
    }

    return config;
})

axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {

    let rejection  = error.response;

    if (rejection.status == 422 && rejection.data.errors) {
        let errors = rejection.data.errors;
        let messages = Object.keys(errors).map((key)=> `${store.getters.translations[key]} - ${Array.isArray(errors[key]) ? store.getters.translations[errors[key][0]] : JSON.stringify(store.getters.translations[errors[key]])}`);
        messages.forEach((message)=> {
            Vue.notify({
                group: "server",
                text: message,
                title: 'Invalid Data sent',
                type: 'error'
            });
        });
    }
    if (rejection.status == 404) {
        return;
    }

    return Promise.reject(error.response);
});
