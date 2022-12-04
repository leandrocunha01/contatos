<template>
    <v-form
        ref="form"
        v-model="preventForm"
        lazy-validation>
        <v-container fluid>
            <v-alert v-for="(apiError, i) in apiErrors" v-bind:key="i" type="error">
                {{ apiError[0] }}
            </v-alert>
            <v-row>
                <v-col cols="12">
                    <v-text-field
                        v-model="register.name"
                        :rules="validations.name"
                        label="Nome"
                        required></v-text-field>
                    <v-text-field
                        v-model="register.email"
                        :rules="validations.email"
                        label="E-mail"
                        required
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    sm="6">
                    <v-text-field
                        type="password"
                        v-model="register.password"
                        :rules="validations.password"
                        label="Senha"
                        required
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    sm="6">
                    <v-text-field
                        type="password"
                        v-model="register.passwordConfirm"
                        label="Senha"
                        required
                    ></v-text-field>
                </v-col>
                <v-btn
                    color="success"
                    class="mr-4"
                    :disabled="register.preventForm"
                    v-on:click="submit">
                    Registrar
                </v-btn>
            </v-row>
        </v-container>
        <v-dialog
            v-model="dialog"
            persistent
            max-width="290"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Mensagem
                </v-card-title>
                <v-card-text>
                    Olá {{ register.name }}, seu cadastro foi realizado com sucesso!
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="green darken-1"
                        text
                        v-on:click="$router.push({ name: 'contacts' })">
                        Login
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-form>
</template>
<script>
export default {
    data: () => ({
        register: {
            name: '',
            email: '',
            password: '',
            passwordConfirm: '',
        },
        validations: {
            name: [
                v => !!v || 'Digite seu nome',
            ],
            email: [
                v => !!v || 'E-mail é obrigatório',
                v => /.+@.+\..+/.test(v) || 'E-mail precisa ser válido',
            ],
            password: [
                v => !!v || 'Senha é brigatória',
            ],
            passwordConfirm: [
                v => !!v || 'A confirmação é obrigatória'
            ]
        },
        select: null,
        checkbox: false,
        preventForm: false,
        apiErrors: [],
        dialog: false
    }),

    methods: {
        submit() {
            if (this.$refs.form.validate()) {
                this.preventForm = true
                this.$http.post('/register', this.register).then(response => {
                    this.dialog = true
                    this.register.name = response.data.name
                }).catch(error => {
                    this.apiErrors = error.response.data.errors
                })
            }
        }
    },
}
</script>
