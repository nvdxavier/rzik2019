import Vue from 'vue'
import ViewMusicFile from './components/ViewMusicFile'
import Hello from './components/Hello'

require('../css/app.css');

// new Vue(
//     {
//         template: '<ViewMusicFile/>',
//         components: { ViewMusicFile },
//     }
// ).$mount('#blockmusic');
Vue.component('vuesuite', ViewMusicFile);

new Vue({
    el: '#blockmusic',
    delimiters: ['${', '}'],
    data: {
        'message': 'Valar morgulis',
        'lien': "https://localhost/home",
        'Style1': {fontcolor: 'red'},
        'compteur': 0,
        visiteur: 'anonyme',
        maClasse: 'bg-red',
        ok: true,
        mesHobbies: [
            {vice: 'luxure', couleur: ['bleu', 'rouge'], dieu: 'aphrodite'},
            {vice: 'soulographie', couleur: ['vermillon', 'rouge'], dieu: 'baccus'},
            {vice: 'voyeurisme', couleur: ['indigo', 'vert'], dieu: 'zeus'},
        ]
    },
    computed: {},
    methods: {
        incrementation: function () {
            this.compteur++;
        },
        decrementation: function () {
            this.compteur--;
        },
        showMessage: function () {
            return this.message;
        },
        show: function () {
            this.ok = !this.ok;
            (this.$refs.boutton.innerText == 'Cacher') ? this.$refs.boutton.innerText = 'Afficher' : this.$refs.boutton.innerText = 'Cacher';
        }
    },
});
