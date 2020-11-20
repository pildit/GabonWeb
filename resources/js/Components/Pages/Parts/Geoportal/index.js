import _ from 'lodash';

/* Map imports */
import Vue from 'vue';
import VueLayers from 'vuelayers'
import 'vuelayers/lib/style.css' // needs css-loader
import GeoportalPage from "./Vue/GeoportalPage.vue";

import store from 'store/store';
import PrettyCheckbox from 'pretty-checkbox-vue';
import VCalendar from 'v-calendar';
import VueRangeSlider from "vue-range-component";

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
        <div>
            <input type="checkbox" v-model="checked"
                v-bind:id="text"
                v-bind:value="checked"
                v-on:click="$emit('click')"
                v-on:input="$emit('input', $event.target.checked)"
            />
            <p-check class="p-default p-curve" name="check" color="success" v-model="checked"></p-check>
            <label v-bind:for="text">{{ text }}</label>
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
            <button v-on:click="$emit('click')">
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
