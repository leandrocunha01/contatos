<template ref="ContactForm">
    <v-dialog
        v-model="showContactForm"
        persistent
        max-width="90%">
        <v-form ref="form">
            <v-card>
                <v-card-title>
                    <span v-if="isNew" class="text-h5">Novo Contato</span>
                    <span v-else class="text-h5">Atualizar Contato</span>
                </v-card-title>
                <v-card-text>
                    <v-alert v-if="responseSuccess" dense type="success">{{ responseSuccess }}</v-alert>
                    <v-alert v-for="(apiError, i) in apiErrors" v-bind:key="i" type="error">
                        {{ apiError[0] }}
                    </v-alert>
                    <v-container>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field :rules="validations.name" v-model="contact.name" label="Nome" required/>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field :rules="validations.email" v-model="contact.email" label="E-mail"
                                              required/>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field :rules="validations.phone" v-model="contact.phone" label="Telefone"
                                              required/>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field :rules="validations.cpf" v-model="contact.cpf" label="CPF" required/>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field :rules="validations.address.cep" v-on:focusout="getViaCep"
                                              v-model="contact.address.cep" label="Cep"
                                              :append-icon="'mdi-map-marker'"
                                              @click:append="showFindCepComponent"
                                              required/>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field :rules="validations.address.address"
                                              v-model="contact.address.address" label="Logradouro" required/>
                            </v-col>
                            <v-col cols="1">
                                <v-text-field :rules="validations.address.number"
                                              v-model="contact.address.number" v-on:focusout="getLatLng" label="Número"
                                              required/>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field v-model="contact.address.complement" label="Complemento" required/>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field :rules="validations.address.district"
                                              disabled v-model="contact.address.district" label="Bairro" required/>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field :rules="validations.address.city"
                                              disabled v-model="contact.address.city" label="Cidade" required/>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field :rules="validations.address.state"
                                              disabled v-model="contact.address.state" label="Estado" required/>
                            </v-col>
                            <input type="hidden" v-model="contact.address.lat"/>
                            <input type="hidden" v-model="contact.address.lng"/>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="closeModal">
                        Fechar
                    </v-btn>
                    <v-btn v-if="isNew && showFetchButton"
                           color="blue darken-1"
                           text
                           :loading="loading"
                           :disabled="loading"
                           v-on:click="submitCreateContact">
                        Cadastrar Contato
                    </v-btn>
                    <v-btn v-if="!isNew && showFetchButton"
                           :loading="loading"
                           :disabled="loading"
                           color="blue darken-1"
                           text
                           v-on:click="submitUpdateContact">
                        Salvar
                    </v-btn>

                </v-card-actions>
            </v-card>
        </v-form>
        <FindCepComponent @geoApiAddress="geoAddress" ref="findCep"/>
    </v-dialog>
</template>
<script>
import FindCepComponent from "@/components/FindCepComponent";
import viacep from "@/services/viacep";
import geoApi from "@/services/geoapi";

export default {
    components: {
        FindCepComponent,
    },
    data() {
        return {
            showContactForm: false,
            showAddress: false,
            contact: {
                id: 0,
                name: '',
                phone: '',
                email: '',
                cpf: '',
                address: {
                    address: '',
                    number: '',
                    complement: '',
                    district: '',
                    city: '',
                    state: '',
                    cep: '',
                    lat: '',
                    lng: '',
                }
            },
            validations: {
                name: [v => !!v || 'Digite o nome',],
                phone: [v => !!v || 'Digite o telefone',],
                email: [v => /.+@.+\..+/.test(v) || 'Digite um E-mail válido',],
                cpf: [v => !!v || 'Digite o CPF',],
                address: {
                    address: [v => !!v || 'Digite o Logradouro',],
                    number: [v => !!v || 'Digite Número',],
                    district: [v => !!v || 'Não foi possível achar o bairro',],
                    city: [v => !!v || 'Não foi possível achar a Cidade',],
                    state: [v => !!v || 'Não foi possível achar o estado',],
                    cep: [v => !!v || 'Digite seu o CEP ou faça uma busca',],
                },
            },
            isNew: false,
            responseSuccess: '',
            loading: false,
            disabled: false,
            apiErrors: [],
            showFetchButton: true
        }
    },
    methods: {
        contactCreate() {
            this.showContactForm = true
            this.isNew = true
            this.showFetchButton = true
        },
        contactEdit(contact, isNew = false) {
            this.showContactForm = true
            this.contact = contact
            this.isNew = isNew
            this.showFetchButton = true
        },
        showFindCepComponent() {
            this.$refs.findCep.showFindCep()
        },
        geoAddress(geoApiAddress) {
            if (geoApiAddress.address_components !== undefined) {
                let address = geoApiAddress.address_components
                let geometry = geoApiAddress.geometry
                this.setAddressByApi(
                    {
                        number: address[0].long_name ?? '',
                        address: address[1].long_name ?? '',
                        district: address[2].long_name ?? '',
                        city: address[3].long_name ?? '',
                        cep: address[6].short_name ?? '',
                        state: address[4].short_name ?? '',
                        lat: geometry.location.lat ?? '',
                        lng: geometry.location.lng ?? ''
                    })
            }
        },
        submitCreateContact() {
            this.loading = true
            this.disabled = true
            if (this.$refs.form.validate()) {
                this.$http.post('/contacts', this.contact).then(() => {
                    this.afterSuccess('Contato criado com sucesso!')
                }).catch(error => {
                    this.afterError(error.response.data.errors)
                })
            }
        },
        submitUpdateContact() {
            this.loading = true
            this.disabled = true
            if (this.$refs.form.validate()) {
                this.$http.put(`/contacts/${this.id}`, this.contact).then(() => {
                    this.afterSuccess('Atualizado com sucesso!')
                }).catch(error => {
                    this.afterError(error.response.data.errors)
                })
            }
        },
        closeModal() {
            this.responseSuccess = ''
            this.showContactForm = false
        },
        afterSuccess(message) {
            this.responseSuccess = message
            this.loading = false
            this.disabled = false
            this.apiErrors = []
            this.showFetchButton = false
        },
        afterError(error) {
            this.loading = false
            this.disabled = false
            this.apiErrors = error
        },
        setAddressByApi({number, address, district, city, cep, state, lat, lng}) {
            this.contact.address.number = number
            this.contact.address.address = address
            this.contact.address.district = district
            this.contact.address.city = city
            this.contact.address.cep = cep
            this.contact.address.state = state
            this.setLatLng(lat, lng)
        },
        setLatLng(lat, lng) {
            this.contact.address.lat = lat
            this.contact.address.lng = lng
        },
        getViaCep() {
            let cep = this.contact.address.cep
            if (cep.length >= 8) {
                viacep.get(`/${cep}/json`).then(response => {
                    let data = response.data
                    this.setAddressByApi(
                        {
                            district: data.bairro,
                            address: data.logradouro,
                            city: data.localidade,
                            cep: data.cep,
                            state: data.uf
                        })
                })
            }
        },
        getLatLng() {
            geoApi.get(`json?address=${this.contact.address.address}, ${this.contact.address.number}`).then(response => {
                let geometry = response.data.results[0].geometry
                this.setLatLng({ lat: geometry.location.lat, lng: geometry.location.lng })
            })
        }
    }
}
</script>
