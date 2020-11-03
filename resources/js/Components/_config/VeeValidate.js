import fr from 'vee-validate/dist/locale/fr';
import Vue from 'vue';
import store from "store/store";
import {Validator} from 'vee-validate';

Validator.localize('fr', fr);

Vue.prototype.$setErrorsFromResponse = function(errorResponse) {
    // only allow this function to be run if the validator exists
    if(!this.hasOwnProperty('errors')) {
        return;
    }

    // clear errors
    this.errors.clear();

    // check if errors exist
    if(!errorResponse.hasOwnProperty('errors')) {
        return;
    }

    let errorFields = Object.keys(errorResponse.errors);

    // insert laravel errors
    errorFields.map(field => {
        let errorString = errorResponse.errors[field].join(', ');
        this.errors.add({field: field, msg: store.getters.translations[errorString]});
    });
};
