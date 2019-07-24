<template>
    <div class="filsDeux">
        <p>Je suis le template fils{{filsVar}}</p>
        <hr>
        propriété envoyé de l'extérieur par le composant pere: {{ proprieteVisiblePourMonFrere }}
        <button @click="sendDataToParent">Envoyer des données au père</button>
        <h3>Je suis le second fils</h3>
        <p>c'est le contenu de la variable de mon frere : {{proprieteVisiblePourMonFrere}}</p>
    </div>
</template>

<script>
    export default {
        props: {
            'proprieteVisiblePourMonFrere': String,
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
            }
        }
    }
</script>

<style scoped>
    .filsDeux {
        border: #191aff 2px solid;
    }
</style>