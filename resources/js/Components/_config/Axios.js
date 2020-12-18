import axios from 'axios';
import Vue from 'vue';
import store from "store/store";
import join from 'url-join';
import finallyBlock from 'promise.prototype.finally'

finallyBlock.shim();

let translate = (key) => {
    return store.getters.translations[key] || `*${key}*`;
}

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
        config.headers['Authorization'] = `Bearer ${Vue.$jwt.getToken()}`
    }
    if(!config.data) {
        config.data = JSON.stringify({});
    }
    return config;
})

axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {

    let rejection  = error.response;

    if (rejection.status == 422 && rejection.data.errors) {
        let errors = rejection.data.errors;

        let messages = Object.keys(errors).map((key)=> `${translate(key)} - ${Array.isArray(errors[key]) ? translate(errors[key][0]) : JSON.stringify(translate(errors[key]))}`);
        messages.forEach((message)=> {
            Vue.notify({
                group: "server",
                text: message,
                title: translate('validation_failed_title'),
                type: 'error'
            });
        });
    }
    // if (rejection.status == 404) {
    //     return;
    // }
    if (rejection.status == 401 && window.location.pathname != '/login') {
        window.location.href = '/login';
        return;
    }

    return Promise.reject(error.response);
});
