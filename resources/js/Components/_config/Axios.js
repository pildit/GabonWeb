import axios from 'axios';
import join from 'url-join';
import finallyBlock from 'promise.prototype.finally'

finallyBlock.shim();

let isAbsoluteURLRegex = /^(?:\w+:)\/\//;

axios.interceptors.request.use((config) => {
    // Concatenate base path if not an absolute URL
    if ( !isAbsoluteURLRegex.test(config.url) ) {
        config.url = join(process.env.MIX_APP_URL, config.url);
    }

    return config;
})
