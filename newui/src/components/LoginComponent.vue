<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4>
                <v-card class="elevation-12">
                    <v-toolbar dark color="primary">
                        <v-toolbar-title>Login {{ $store.state.token }}</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form>
                            <v-text-field
                                v-model="auth.email"
                                name="email"
                                label="E-mail"
                                type="text"
                            ></v-text-field>
                            <v-text-field
                                v-model="auth.password"
                                id="password"
                                name="password"
                                label="Password"
                                type="password"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" v-on:click="loginFetch()">Entrar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

export default {
    name: 'LoginComponent',
    props: {
        source: String,
    },
    data() {
        return {
            auth: {email: 'leandrocunha01@gmail.com', password: '123123'},
        }
    },
    methods: {
        loginFetch() {
            this.$store.dispatch('loginFetch', this.auth)
        }
    },
}
</script>

<style></style>
