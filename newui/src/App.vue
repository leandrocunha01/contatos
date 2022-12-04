<template>
    <v-app>
        <v-app-bar color="primary" class="flex-grow-0" app dark>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title>Contatos</v-app-bar-title>
        </v-app-bar>
        <v-navigation-drawer app v-model="drawer">
            <v-divider></v-divider>
            <v-list dense nav>
                <v-list-item v-for="item in items" :key="item.route" link :to="item.route">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item v-on:click="$store.dispatch('logoutFetch')" link>
                    <v-list-item-icon>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>Sair</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

export default {
    name: 'App',
    data: () => ({
        drawer: false,
        isLogin: false,
        items: [
            {title: 'Contatos', icon: 'mdi-view-dashboard', route: '/contacts'},
            {title: 'Registrar', icon: 'mdi-view-dashboard', route: '/register'},
        ],
    }),
    mounted() {
        this.$store.dispatch('checkIsLogin')
    }
}
</script>
