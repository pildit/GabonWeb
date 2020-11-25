import _ from 'lodash';

/* Map imports */
import Vue from 'vue';
import VueLayers from 'vuelayers'
import 'vuelayers/lib/style.css' // needs css-loader
import GeoportalPage from "./Vue/GeoportalPageLeaflet.vue";

import store from 'store/store';
import PrettyCheckbox from 'pretty-checkbox-vue';
import VCalendar from 'v-calendar';
import VueRangeSlider from "vue-range-component";

/* Bootstrap */
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";

/* Load the map */
Vue.use(VueLayers)
Vue.use(PrettyCheckbox);

// Use v-calendar & v-date-picker components
Vue.use(VCalendar, { componentPrefix: 'v' });
Vue.use(VueRangeSlider);

// Checkbox component
Vue.component('rcp-checkbox', {
    data: function () {
        return {
            checked: false
        }
    },
    props: ['text'],
    template: `
        <div class="form-check">
            <input type="checkbox" 
                class="form-check-input"
                v-model="checked"
                v-bind:id="text"
                v-bind:value="checked"
                v-on:click="$emit('click')"
                v-on:input="$emit('input', $event.target.checked)"
            />
            <label 
                class="form-check-label"
                v-bind:for="text"><h5 class="text-dark">{{ text }}</h4></label>
        </div>
    `
})

Vue.component('rcp-alert-box', {
    template: `
    <div class="rcp-alert-box">
      <strong>Error!</strong>
      <slot></slot>
    </div>
  `
})

Vue.component('rcp-button', {
    data: function () {
        return {
        }
    },
    props: ['text'],
    template: `
            <button
                class="btn btn-primary mt-0"
                v-on:click="$emit('click')">
                {{ text }}
                <slot></slot>
            </button>`
})

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { GeoportalPage },
        data: {}
    }

    return new Vue(_.merge(options, vueOptions));
}
