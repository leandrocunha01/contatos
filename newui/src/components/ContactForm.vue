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
                                <v-text-field :rules="validations.address.cep" v-model="contact.address.cep" label="Cep"
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
                                              v-model="contact.address.number" label="Número" required/>
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
                        @click="showContactForm = false">
                        Cancelar
                    </v-btn>
                    <v-btn v-if="isNew"
                        color="blue darken-1"
                        text
                        v-on:click="submitCreateContact">
                        Cadastrar Contato
                    </v-btn>
                    <v-btn v-if="!isNew"
                        color="blue darken-1"
                        text
                        @click="showContactForm = false">
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

export default {
    components: {
        FindCepComponent,
    },
    data() {
        return {
            showContactForm: false,
            showAddress: false,
            contact: {
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
            isNew: false
        }
    },
    methods: {
        contactCreate() {
            this.showContactForm = true
            this.isNew = true
        },
        contactEdit(contact) {
            this.showContactForm = true
            this.contact = contact
            this.isNew = false
        },
        showFindCepComponent() {
            this.$refs.findCep.showFindCep()
        },
        geoAddress(geoApiAddress) {
            if (geoApiAddress.address_components !== undefined) {
                let address = geoApiAddress.address_components
                this.contact.address.number = address[0].long_name ?? ''
                this.contact.address.address = address[1].long_name ?? ''
                this.contact.address.district = address[2].long_name ?? ''
                this.contact.address.city = address[3].long_name ?? ''
                this.contact.address.cep = address[6].short_name ?? ''
                this.contact.address.state = address[4].short_name ?? ''

            }
            if (geoApiAddress.geometry !== undefined) {
                let geometry = geoApiAddress.geometry
                this.contact.address.lat = geometry.location.lat ?? ''
                this.contact.address.lng = geometry.location.lng ?? ''
            }
        },
        submitCreateContact() {
            this.$refs.form.validate()
        }
    }
}
</script>
