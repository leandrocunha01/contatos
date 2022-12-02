import { defineStore} from "pinia";
import axios from "axios";

export const userAuthStore = defineStore('auth',{
    state: () => ({
        authUser: null
    }),
        getters: {
        user: (state) => state.authUser
    },
    actions: {
        async getUserData(){
            axios.post('/user', this.credentials).then((response) => {
                this.authUser = response.data.data
            })
        }
    }
})
