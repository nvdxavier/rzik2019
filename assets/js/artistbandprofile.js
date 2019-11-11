import Vue from 'vue'
import axios from 'axios'
import BootstrapVue from 'bootstrap-vue'
import VueResource from "vue-resource"
import VueDump from 'vue-dump';

Vue.use(BootstrapVue);
Vue.use(VueResource);
Vue.use(VueDump);

new Vue({
    el: '#artistbandprofile',
    delimiters: ['${', '}'],
    data: {
        followstate: null,
        followbuttontext: 'Follow',
        followartisturl: 'https://' + window.location.hostname + '/api/follow/artistband/',
        getartisturl: 'https://' + window.location.hostname + '/api/artistband/',
        getstatustate: 'https://' + window.location.hostname + '/api/getstatus/artistband/',
        projectsofuserurl: 'https://' + window.location.hostname + '/api/playlist/project/',
        login: 'https://' + window.location.hostname + '/login',
        register: 'https://' + window.location.hostname + '/register',
        getartistbandid: '',
        getcurrentuser: '',
        followartistmessage: null,
        showpopover: false,
        showpopoverlog: false,
        connectionmessage: '',
        projectsofusercollection: '',
        root: 'https://' + window.location.hostname
    },
    beforeMount() {
        this.getartistbandid = this.$el.attributes['data-name'].value;
        this.getcurrentuser = this.$el.attributes['data-currentuser'].value;
    },
    mounted() {
        this.getfollowstate();
        this.getprojectforuser();
    },
    methods: {
        showModal() {
            this.$refs['my-modal'].show()
        },
        patchfollowstate: function () {
            if (this.getcurrentuser) {
                axios.patch(this.followartisturl + this.getartistbandid + '/' + this.getcurrentuser,
                    {
                        id: this.getartistbandid,
                        iduser: this.getcurrentuser
                    })
                    .then((response) => {
                        if (response.data.followartistbandstate === true) {
                            console.log('succes');
                            this.followstate = 'success';
                            this.followbuttontext = 'Stop Follow';
                        } else {
                            this.followstate = 'outline-primary';
                            this.followbuttontext = 'Follow';
                        }
                        this.showpopover = true;
                        this.followartistmessage = response.data.message;
                    })
                    .catch((error) => {
                        console.log(error);
                        alert('not patched')
                    });
            } else {
                this.showModal();
                this.connectionmessage = 'Pour suivre cet artiste, veuillez créer un compte Rzik gratuit ou vous connecter si vous en possédez déjà un :'
            }

        },
        getfollowstate: function () {
            if (this.getcurrentuser) {
                axios.get(this.getstatustate + this.getartistbandid + '/' + this.getcurrentuser)
                    .then((response) => {
                        if (response.data.followartistbandstate === false) {
                            this.followstate = 'success';
                            this.followbuttontext = 'Stop Follow';
                        } else {
                            this.followstate = 'outline-primary';
                            this.followbuttontext = 'Follow';
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                this.followstate = 'outline-primary';
                this.followbuttontext = 'Follow';
            }

        },
        getprojectforuser: function () {
            axios.get(this.projectsofuserurl + this.getartistbandid)
                .then((response) => {
                    this.projectsofusercollection = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        }

    }
});
