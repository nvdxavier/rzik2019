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
        idmusic: '',
        url: 'https://' + window.location.hostname + '/api/artistband/projects/',
        paramValue: window.location.pathname.substr(1).split('/')[1],
        urladdplaylist: 'https://' + window.location.hostname + '/api/playlist/add',
        urlcreateplaylist: 'https://' + window.location.hostname + '/api/create/playlist/add/music',
        urladdmusictoplaylist: 'https://' + window.location.hostname + '/api/add/music/toplaylist',
        checkmusictoplaylist: 'https://' + window.location.hostname + '/api/playlist/check/musicid',
        currentplaylist: null,
        musicid: null,
        errors: [],
        name: null,
        selectedplaylist: [],
        connectarray: [],
        modalmessage: null,
        modalmessagelogin: null,
        modalmessageregister: null,
    },
    mounted() {
        this.project = this.url + this.paramValue;
        axios.get(this.project)
            .then(response => (this.infos = response))
            .catch((error) => {
                console.log(error);
            });
    },
    methods: {
        checkmusicinplaylist(id, plid) {
            axios.post(this.checkmusictoplaylist, {idmusic: id, idplaylist: plid})
                .then((response) => {

                    if (response.data.isinplaylist === undefined) {
                        var div = null;
                    } else {
                        var div = document.createElement("div");
                        var textnode = document.createTextNode(response.data.isinplaylist);
                        div.appendChild(textnode);
                        document.getElementById("statusmessage-" + plid).appendChild(div);
                    }

                }).catch((error) => {
                console.log(error);
            })
        },
        addToPlaylist(id) {
            axios.post(this.urladdplaylist, {idmusic: id})
                .then((response) => {
                    if (!Object.keys(response.data).length) {
                        this.currentplaylist = 'You don\'t have any playlist created yet';
                        this.musicid = id;
                        this.showModal();

                    } else if (response.data.connected === false) {

                        this.modalmessage = response.data.message;
                        this.modalmessagelogin = 'https://' + window.location.hostname + response.data.login;
                        this.modalmessageregister = 'https://' + window.location.hostname + response.data.register;
                        this.$refs['message-modal'].show();

                    } else {
                        this.currentplaylist = response.data;
                        this.musicid = id;
                        this.showModal();
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showModal() {
            this.$refs['playlists-modal'].show();
        },
        checkForm: function () {
            this.errors = [];

            if (!this.name) {
                this.errors.push('Name required.');
            } else if (!this.validName(this.name)) {
                this.errors.push('Valid name required(string lenght: 5 min - 50 max, no [],%.)');
            }

            if (!this.errors.length) {
                axios.post(this.urlcreateplaylist, {name: this.name, musicid: this.musicid})
                    .then((response) => {
                        // console.log(response.data.message);
                        alert(response.data.message);
                    })
                    .catch((error) => {
                        console.log(error);
                        alert('Erreur Création playlist');
                    });
            }
        },
        validName: function (name) {
            var re = /^[a-z A-Z0-9-\/\\._&îéèàêâùïüë!?()+,'\"]{5,50}$/;
            return re.test(name);
        },
        addmusictoplaylist(id) {
            axios.post(this.urladdmusictoplaylist, {musicid: this.musicid, selectedplaylist: id})
                .then((response) => {
                    this.modalmessage = response.data.message
                })
                .catch((error) => {
                    console.log(error);
                });

        }
    },
});
