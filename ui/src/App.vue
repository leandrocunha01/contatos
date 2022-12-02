<script setup>
import {RouterLink, RouterView} from 'vue-router'
import  LoginView  from './views/LoginView.vue'
</script>

<template>
    <header>
        <div>

                <RouterLink to="/contacts">Contatos</RouterLink>

        </div>
    </header>

        <RouterView/>


<!--        <LoginView/>-->

</template>
<script>

export default {
    data(){
        return{
            userdata: ''
        }
    },
    created() {
        this.userData = localStorage.getItem('userData')
        console.log(this.userData)
    }
}
</script>
