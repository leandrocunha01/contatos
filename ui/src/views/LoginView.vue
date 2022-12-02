<template>
    <main>
        {{ credentials.email }}<br>
        <input v-model="credentials.email">
        <br>
        <input v-model="credentials.password">
        <br>
        <button v-on:click="login">Entrar</button>

    </main>
</template>
<script>
import {useCounterStore} from "../stores/counter";

export default {
    data() {
        return {
            credentials:
                {
                    email: 'leandrocunha01@gmail.com',
                    password: null,
                }
        }
    },
    methods: {
        login() {
            this.$http.post('/login', this.credentials).then((response) => {
                localStorage.setItem('userToken', response.data.data.token.plainTextToken)
                this.$router.push({ name: 'contacts' })
            } )
        }
    },
    mounted() {

    }
}
</script>
