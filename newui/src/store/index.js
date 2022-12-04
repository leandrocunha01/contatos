import Vue from 'vue'
import Vuex from 'vuex'
import login from "@/services/login";

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
        }
    },
    mutations: {
        loginSuccess(state, token) {
            state.isLogin = true
            state.token = token.token
            state.user = null
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
                var token = response.data.data.token.plainTextToken
                commit('loginSuccess', { token: token});
            })
        }
    },
    modules: {}
})
