import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from "axios";

import './assets/main.css'



const app = createApp(App)
const token =  localStorage.getItem('userToken')

app.config.globalProperties.$http = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        "Content-type": "application/json",
        "Authorization": token?`Bearer ${token}`:''
    },
})

app.use(createPinia())
app.use(router)


app.mount('#app')
