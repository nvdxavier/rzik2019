import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VueResource from 'vue-resource'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueResource);
Vue.use(BootstrapVue);

new Vue({
    el: '#blockmember',
    delimiters: ['${', '}'],
    data: {
        article: true,
        info: null,
        errors: [],
        title: '',
        content: '',
        tag: '',
        tagged: '',
        url: "https://localhost/api/post_article"
        // url: "{{ path('api_post_article') }}"
    },
    methods: {
        showModal() {
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.$refs['my-modal'].hide()
        },
        toggleModal() {
            // We pass the ID of the button that we want to return focus to
            // when the modal has hidden
            this.$refs['my-modal'].toggle('#toggle-btn')
        },
        buttonClicked: function () {
            axios.post(this.url, {title: this.title, content: this.content, tag: this.tag})
                .then((response) => {
                    console.log(response);
                    alert('success');
                })
                .catch((error) => {
                    console.log(error);
                    alert('non');
                });
        },

    }


});

