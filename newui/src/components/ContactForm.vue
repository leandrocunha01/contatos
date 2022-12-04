<template>
    <v-dialog
        v-model="showContactForm"
        persistent
        max-width="90%">
        <v-card>
            <v-card-title>
                <span v-if="isNew" class="text-h5">Novo Contato</span>
                <span v-else class="text-h5">Atualizar Contato</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field v-model="contact.name" label="Nome" required/>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field v-model="contact.email" label="E-mail" required/>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field v-model="contact.phone" label="Telefone" required/>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field v-model="contact.cpf" label="CPF" required/>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field v-model="contact.address.cep" label="Cep" required/>
                        </v-col>
                        <v-col cols="5">
                            <v-text-field v-model="contact.address.address" label="Endereço" required/>
                        </v-col>
                        <v-col cols="1">
                            <v-text-field v-model="contact.address.number" label="Número" required/>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field v-model="contact.address.complement" label="Complemento" required/>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field disabled v-model="contact.address.district" label="Bairro" required/>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field disabled v-model="contact.address.city" label="Cidade" required/>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field disabled v-model="contact.address.state" label="Estado" required/>
                        </v-col>
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
                <v-btn
                    color="blue darken-1"
                    text
                    @click="showContactForm = false">
                    Salvar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    data() {
        return {
            showContactForm: this.open,
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
                }
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
        }
    }
}
</script>
