import Vue from 'vue'
import store from 'store/store'



Vue.directive('permission', {
    inserted: function (el, binding, vnode) {
        const permissions = store.state.loggedUser.permissions
        if (binding.value) {
            let hasPermission = permissions.indexOf(binding.value) > -1
            if (!hasPermission) {
                el.parentNode.removeChild(el)
            }
        } else {
            console.error('You must specify a permission ID')
        }
    }
})
