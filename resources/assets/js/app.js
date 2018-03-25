
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.flash = function(message){
    window.events.$emit('flash',message);
};



Vue.component('flash', require('./components/Flash.vue'));


const app = new Vue({
    el: '#app'
});
