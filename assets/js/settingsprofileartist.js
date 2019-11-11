import Vue from 'vue'
import axios from 'axios'
import VueDump from 'vue-dump'
import BootstrapVue from 'bootstrap-vue'
import VeeValidate from 'vee-validate'

Vue.use(BootstrapVue);
Vue.use(VueDump);
Vue.use(VeeValidate);

new Vue({
    el: '#profil_artist',
    delimiters: ['${', '}'],
    data: {
        infosuser: null,
        getmember: 'https://' + window.location.hostname + '/api/member/',
        patchmember: 'https://' + window.location.hostname + '/api/update/member/',
        patchpasswordroute: 'https://' + window.location.hostname + '/api/update/password/',
        getmyprojects: 'https://' + window.location.hostname + '/api/projectsowner',
        tokenmember: (new URL(document.location)).searchParams.get('token'),
        getmemberid: '',
        firstname: '',
        lastname: '',
        container: '',
        content: '',
        resetpasswordroute: '',
        passwordform: false,
        password: '',
        messagetype: null,
        myprojects: '',
        root: 'https://' + window.location.hostname
    },
    beforeMount() {
        this.getmemberid = this.$el.attributes['data-name'].value;
        this.getmemberinfos = this.getmember + this.getmemberid;
        this.patchmemberinfos = this.patchmember + this.getmemberid + '?id=' + this.getmemberid;
        this.patchpassword = this.patchpasswordroute + '?token=' + this.tokenmember;
        this.resetpasswordroute = 'https://' + window.location.hostname + '/api/reset/password/';
        axios.get(this.getmemberinfos)
            .then(response => (this.infosuser = response))
        ;
    },
    mounted() {
        this.getprojectsowner();
        if (this.tokenmember) {
            this.passwordform = true;
        }
    },
    methods: {
        patchMember: function () {
            axios.patch(this.patchmemberinfos,
                {
                    firstname: this.firstname,
                    lastname: this.lastname,
                })
                .then((response) => {
                    console.log(response);
                    alert('success');
                })
                .catch((error) => {
                    console.log(error);
                    alert('non');
                });
        },
        patchPassword() {
            axios.patch(this.resetpasswordroute,
                {
                    password: this.password
                })
                .then((response) => {
                    this.toggleModal();
                })
                .catch((error) => {
                    console.log(error);
                    alert('error password');
                });
        },
        reload() {
            this.container = document.getElementById("passwordtemplate");
            this.content = container.innerHTML;
            container.innerHTML = content;
        },
        validateBeforeSubmit() {
            this.$validator
                .validateAll()
                .then((response) => {
                    // Validation success if response === true
                    if (response === true) {
                        this.patchPassword();
                        this.messagetype = 'success! Your password have been modified it will take effect for the next connection';
                    }
                })
                .catch(function (e) {
                    // Catch errors
                    console.log(e);
                    this.messagetype = 'Sorry!';

                })
        },
        showModal() {
            this.$refs['modal-message'].show()
        },
        hideModal() {
            this.$refs['modal-message'].hide()
        },
        toggleModal() {
            // We pass the ID of the button that we want to return focus to
            // when the modal has hidden
            this.$refs['modal-message'].toggle('#toggle-btn')
        },
        getprojectsowner: function () {
            axios.get(this.getmyprojects)
                .then((response) => {
                    this.myprojects = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
});
