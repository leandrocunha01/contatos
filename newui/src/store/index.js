import Vue from 'vue'
import Vuex from 'vuex'
import login from "@/services/login";
import router from "@/router";

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        isLogin: false,
        token: null,
        user: null,
    },
    getters: {
        getToken: function (state) {
            return state.token
        },
        isLogin: function (state) {
            return state.isLogin
        }
    },
    mutations: {
        loginSuccess(state, token) {
            state.isLogin = true
            state.token = token.token
            localStorage.setItem("accessToken", state.token)
        },
        loginFailure(state) {
            state.isLogin = false
        },
        logout(state) {
            state.isLogin = false
        }
    },
    actions: {
        loginFetch({commit}, auth) {
            login.post('/login', auth).then(response => {
                let token = response.data.data.token.plainTextToken
                commit('loginSuccess', {token: token});
                router.push({ name: 'contacts' })
            })
        }
    },
    modules: {}
})
