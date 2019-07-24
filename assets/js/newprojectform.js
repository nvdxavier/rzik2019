import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

require('../css/app.css');
require('../css/newprojectform.css');

new Vue({
    el: '#newprojectform',
    delimiters: ['${', '}'],
    data: {
        projectbuttonnext: false,
        plname: null,
        descriptionpl: null,
        picturefile: null,
        step: 1,
    },
    methods: {
        onFileChange: function (e) {
            this.picturefile = true;
            this.checkNewProjectForm(this.picturefile);
        },
        checkNewProjectForm: function (e) {
            if (this.plname && this.descriptionpl && this.picturefile) {
                this.projectbuttonnext = true;
            } else {
                this.projectbuttonnext = false;
            }
        },
        prev() {
            this.step--;
        },
        next() {
            this.step++;
        },
    },
    watch: {
        descriptionpl: function (value) {
            this.checkNewProjectForm(value);
        },
        plname: function (value) {
            this.checkNewProjectForm(value);
        },
    }
});

Vue.use(BootstrapVue);
