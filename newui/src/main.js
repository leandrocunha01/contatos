import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import api from './services/api'
import store from './store'
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.prototype.$http = api
Vue.config.productionTip = false


Vue.use(VueGoogleMaps, {load: {key: 'AIzaSyAUp_PkomjqmdHEFyP7WupIcAFy2y9xotY', libraries: 'places'}})

new Vue({
    vuetify,
    router,
    store,
    render: h => h(App)
}).$mount('#app')
