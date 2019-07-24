<template>
    <div class="filsUn">
        <p>Je suis le template fils{{filsVar}}</p>
        <hr>
        Propriété envoyé de l'extérieur par le composant pere: {{ proprieteVisible }}
        <button @click="sendDataToParent">Envoyer des données au père</button>
        <button @click="sentDataToBrother">Envoyer données à mon frêre</button>
    </div>
</template>

<script>
    export default {
        props: {
            'proprieteVisible': String,
        },
        data: function () {
            return {
                'filsVar': 'var du fils',
                'couleurFavoriteDuFils': 'blue'
            }
        },
        methods: {
            sendDataToParent() {
                this.$emit('sentDataFromSon', this.couleurFavoriteDuFils);
            },
            sentDataToBrother() {
                this.$emit('toMyBrother', 'je suis la data de ton frère fils => fils1')
            }
        }
    }
</script>

<style scoped>
    .filsUn {
        border: #ff0921 1px solid;
    }
</style>