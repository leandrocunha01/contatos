import Vue from 'vue'
import VueRouter from 'vue-router'
import LoginComponent from "@/components/LoginComponent";
import store from "@/store";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: LoginComponent
  },
  {
    path: '/contacts',
    name: 'contacts',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/ContactsView.vue')
  }
]

const router = new VueRouter({
  routes
})

router.beforeEach((to, from, next) => {
    if (to.name !== 'home' && !store.getters.isLogin) {
        next({ name: 'home' })
    } else {
        next()
    }
})

router.afterEach(() => {
    console.log(store.getters.isLogin)
})

export default router
