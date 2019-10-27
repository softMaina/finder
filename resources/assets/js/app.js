/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Swal from 'sweetalert2'
window.Vue = require('vue');

Vue.prototype.$eventBus = new Vue()
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.Toast = Toast;
window.Swal = Swal
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('select2', {
    props: ['options', 'value', 'placeholder'],
    template: "<select><slot></slot></select>",
    mounted: function () {
        var vm = this
        $(this.$el)
            .select2({
                data: this.options,
                placeholder: this.placeholder
            })
            .val(this.value)
            .trigger('change')
            // emit event on change.
            .on('change', function () {
                vm.$emit('input', this.value)
            })
    },
    watch: {
        value: function (value) {
            // update value
            $(this.$el)
                .val(value)
                .trigger('change')
        },
        options: function (options) {
            // update options
            $(this.$el).empty().select2({
                data: options
            })
        }
    },
    destroyed: function () {
        $(this.$el).off().select2('destroy')
    }
})
Vue.component('search-component', require('./components/helpers/SearchComponent.vue'));
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('properties-component', require('./components/PropertiesPageComponent.vue'));
Vue.component('property-details-component', require('./components/PropertyDetailsComponent.vue'));

const app = new Vue({
    el: '#app'
});
