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
        getmemberid: ''
    },
    beforeMount() {
        this.getmemberid = this.$el.attributes['data-name'].value;
    },
    mounted() {
        if (!this.followstate) {
            this.followstate = 'outline-primary';
        }
    },
    methods: {
        handlefollowstate: function () {
            axios.get(this.getmemberinfos)
                .then(response => (this.infosuser = response));
        },
        postfollowstate: function () {
            axios.post(this.followartisturl + this.getmemberid, {id: this.getmemberid})
                .then((response) => {
                    this.followbuttontext = 'Followed';
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                    alert('non');
                });
        },
        // patchfollowstate: function(){
        //     axios.patch(this.followartisturl + this.getmemberid,
        //         {
        //             id: this.getmemberid
        //         })
        //         .then((response) => {
        //             console.log(response);
        //             alert('success');
        //         })
        //         .catch((error) => {
        //             console.log(error);
        //             alert('non');
        //         });
        // },

    }
});