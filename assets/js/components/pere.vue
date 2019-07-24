<template>
    <div>
        <hr>
        <button @click="actifComponent = 'fils3-component'">3éme Fils</button>
        <button @click="actifComponent = 'fils4-component'">4éme Fils</button>
        <hr>

        <keep-alive>
            <component :is="actifComponent"></component>
        </keep-alive>
        <p>Je suis le composant pere {{pereVar}}</p>
        <input :style="{borderColor:filsVar}" type="text" v-model="varExterne">
        <fils-component
                :propriete-visible="varExterne"
                @sentDataFromSon="filsVar = $event"
                @toMyBrother="secondSonVar = $event"
        ></fils-component>
        <hr>
        <fils2-component :proprieteVisiblePourMonFrere="secondSonVar"></fils2-component>
    </div>
</template>

<script>
    export default {
        name: "pere",
        data: function () {
            return {
                'pereVar': 'var du père',
                'varExterne': 'je suis la veriable du pere externe',
                'filsVar': 'yellow',
                'secondSonVar': '',
                'actifComponent': 'fils3-component'
            }
        }
    }
</script>

<style scoped>

</style>