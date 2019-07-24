<template>
    <div class="viewmusicfile">
        <div :class="['allblacks',{'bg-red' : changecolor}]" @click="changeClass()">{{hidenNumber}}</div>
        <input type="text" v-model="tentative"> {{showResult}}
    </div>
</template>
<script>
    export default {
        name: 'viewmusicfile',
        // delimiters : ['${', '}'],
        data: function () {
            return {
                hidenNumber: Math.floor(Math.random() * 10),
                tentative: '',
                changecolor: true,
            }
        },
        computed: {
            showResult: function () {
                if (this.tentative == '') {
                    return 'veuiller entamer le jeu';
                } else if (this.tentative == this.hidenNumber) {
                    return 'gagné';
                }
                return 'essaye encore';
            },
        },
        methods: {
            changeClass: function () {
                this.changecolor ? this.changecolor = false : this.changecolor = true;
            },
        }

    }
</script>

<style>

</style>
