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
        items: [
            {title: 'Contacts', icon: 'mdi-view-dashboard', route: '/contacts'},
            {title: 'Register', icon: 'mdi-view-dashboard', route: '/register'},
            {title: 'Forgot Password', icon: 'mdi-view-dashboard', route: '/forgot-password'},
            {title: 'About', icon: 'mdi-view-dashboard', route: '/about'},
        ],
    }),
};
</script>
