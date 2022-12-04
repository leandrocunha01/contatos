import {createRouter, createWebHistory} from 'vue-router'
import LoginView from '../views/LoginView.vue'
import { userAuthStore } from '../stores/auth'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: LoginView
        },
        {
            path: '/contacts',
            name: 'contacts',
            component: () => import('../views/ContactsView.vue')
        }
    ]
})

router.beforeEach((to, from, next) => {
        if (!this.$store.getters.isLogin) {
            next({ name: 'Login' })
        } else {
            next()
        }
})

export default router
