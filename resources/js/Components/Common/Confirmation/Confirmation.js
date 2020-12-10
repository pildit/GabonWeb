import Vue from 'vue';
import store from "../../../Store/store";

var translate = (key) => {
    return store.getters.translations[key] || `*${key}*`;
}

export default (input = {})=> {

    let options = {};
    if(typeof input  == 'string') {
        options.text = input;
    }else {
        options = input;
    };

    return Vue.swal({
        title:  options.title || translate('default_confirmation_title'),
        html:  options.text   || '',
        icon: options.icon || 'warning',
        type: (typeof options.type !== 'undefined') ? options.type : "question",
        width: options.width || 500,
        customClass: options.customClass || {},

        confirmButtonText: options.okText || translate('ok'),
        confirmButtonColor: "#3085d6",

        showCancelButton: !options.hideCancelButton,
        cancelButtonText: options.cancelText || translate('cancel'),
        cancelButtonColor: "#d33",
        showLoaderOnConfirm: options.showLoader,
        reverseButtons: options.reverseButtons,
        preConfirm: options.preConfirm || null,
    });

}
