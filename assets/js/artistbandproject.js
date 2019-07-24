import Vue from 'vue'
import axios from 'axios'
import VueResource from "vue-resource"
import AudioVisual from 'vue-audio-visual'
import VueDump from 'vue-dump';
import VModal from 'vue-js-modal'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueResource);
Vue.use(VueDump);
Vue.use(AudioVisual);
Vue.use(BootstrapVue);
Vue.use(VModal, {componentName: "foo-modal"});

new Vue({
    el: '#artistproject',
    delimiters: ['${', '}'],
    data: {
        info: null,
        projectid: '#projectbyartist',
        // url: "https://localhost/api/artistband/projects/",
        url: 'https://' + window.location.hostname + '/api/artistband/projects/',
        paramValue: window.location.pathname.substr(1).split('/')[2],
        dismissSecs: 10,
        dismissCountDown: 0,
        showDismissibleAlert: false
    },
    methods: {
        show() {
            this.$modal.show('hello-world', {foo: 'bar'})
        },
        hide() {
            this.$modal.hide('hello-world');
        }
    },

    mounted() {
        this.project = this.url + this.paramValue;
        axios.get(this.project)
            .then(response => (this.info = response))
        ;
    },
});
