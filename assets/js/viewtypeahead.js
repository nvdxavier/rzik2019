import Vue from "vue"
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import axios from 'axios'

Vue.use(VueBootstrapTypeahead);

const template = `
<div>
  <vue-bootstrap-typeahead
    class="mb-4"
    v-model="query"
    :data="users"
    :serializer="item => item.login"
    @hit="selectedUser = $event"
    placeholder="Search Cities"
  />

 <h3>Selected User JSON</h3>
 <pre>{{ selectedUser | stringify }}</pre>
</div>
`;


new Vue({
    template,
    components: {
        VueBootstrapTypeahead
    },
    data() {
        return {
            query: '',
            selectedUser: null,
            users: []
        }
    },
    watch: {
        // When the query value changes, fetch new results from
        // the API - in practice this action should be debounced
        query(newQuery) {
            axios.get(`https://localhost/api/search/city/${newQuery}`)
                .then((res) => {
                    this.users = res.data[0];
                    // this.users = res.data.items;
                    // console.log(newQuery);
                    // console.log(res.data.item);
                    // console.log(res.data)
                    // console.log(res.data[0]);
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    filters: {
        stringify(value) {
            return JSON.stringify(value, null, 2);
        }
    },
}).$mount('#artistbandregister');


