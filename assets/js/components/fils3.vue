<template>
    <div class="thirdFils">
        <p>Je suis le troisième fils +comptage juqu'à pour vérfier que cettes valeur {{count}} soit conservé</p>
        <button @click="count++">++</button>
    </div>
</template>

<script>
    export default {

        data: function () {
            return {
                'count': 0
            }
        },
        methods: {}

    }
</script>

<style scoped>
    .thirdFils {
        border: lightcyan 3px solid;
    }
</style>