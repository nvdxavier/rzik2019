import Vue from 'vue'
// import VueDump from 'vue-dump';
import VModal from 'vue-js-modal'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue);
// Vue.use(VueDump);

new Vue({
    el: '#base',
    delimiters: ['${', '}'],
});