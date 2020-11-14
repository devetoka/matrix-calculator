require('./bootstrap');

import Vue from 'vue';
import Calculator from './components/Calculator.vue';

new Vue({
    el: '#app',
    components: {
        Calculator
    }
});
