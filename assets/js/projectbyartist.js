import Vue from 'vue'
import axios from "axios";
import AudioVisual from "vue-audio-visual";
import BootstrapVue from 'bootstrap-vue'
import VueResource from "vue-resource"
import VueDump from 'vue-dump';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue);
Vue.use(AudioVisual);
Vue.use(VueResource);
Vue.use(VueDump);


new Vue({
    el: '#viewprojectbyartist',
    delimiters: ['${', '}'],
    data: {
        infos: null,
        url: 'https://' + window.location.hostname + '/api/artistband/projects/',
        paramValue: window.location.pathname.substr(1).split('/')[1],
    },
    mounted() {
        this.project = this.url + this.paramValue;
        axios.get(this.project)
            .then(response => (this.infos = response))
            .catch((error) => {
                console.log(error);
            });
    },
});
