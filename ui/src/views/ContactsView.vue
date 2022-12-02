<template>
    <div>
        <div v-for="contact in contacts" >
            <button v-on:dblclick="contactEdit"> {{ contact.name }} </button>
        </div>
    </div>
</template>

<script>

export default {
    data(){
        return{
            contacts: []
        }
    },
    mounted() {
        this.$http.get('/contacts', this.credentials).then((response) => {
            this.contacts = response.data
        })
    },
    methods:{
        contactEdit(){
            alert('asd')
        }
    }
}
</script>

<style>
@media (min-width: 1024px) {
    .about {
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
}
</style>
