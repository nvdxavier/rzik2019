import Vue from 'vue'
import axios from 'axios'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);

new Vue({
    el: '#artistbandprofile',
    delimiters: ['${', '}'],
    data: {
        followstate: null,
        followbuttontext: 'Follow',
        followartisturl: 'https://' + window.location.hostname + '/api/follow/artistband/',
        getartisturl: 'https://' + window.location.hostname + '/api/artistband/',
        getstatustate: 'https://' + window.location.hostname + '/api/getstatus/artistband/',
        getmemberid: '',
        getcurrentuser: '',
        followartistmessage: null,
        showpopover: false
    },
    beforeMount() {
        this.getmemberid = this.$el.attributes['data-name'].value;
        this.getcurrentuser = this.$el.attributes['data-currentuser'].value;
    },
    mounted() {
        this.getfollowstate()
    },
    methods: {
        patchfollowstate: function () {
            axios.patch(this.followartisturl + this.getmemberid + '/' + this.getcurrentuser,
                {
                    id: this.getmemberid,
                    iduser: this.getcurrentuser
                })
                .then((response) => {
                    if (response.data.followartistbandstate === true) {
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
                });
        },
        getfollowstate: function () {
            axios.get(this.getstatustate + this.getmemberid + '/' + this.getcurrentuser)
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
        }

    }
});