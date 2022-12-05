<template>
    <v-dialog
        v-model="showModal"
        persistent
        max-width="50%">
        <v-form ref="form">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Buscar meu CEP</span>
                </v-card-title>
                <v-card-subtitle>Digite Rua e número e ache seu cep</v-card-subtitle>
                <v-card-text>
                    <v-container>
                        <v-alert v-if="resultStatus === 'ZERO_RESULTS'" dense type="warning">Sem resultados para busca</v-alert>
                        <v-row>
                            <v-col cols="10">
                                <v-text-field v-model="address" placeholder="Rua João Zaleski, 842" required/>
                            </v-col>
                            <v-col cols="2">
                                <v-btn
                                    :loading="loading"
                                    :disabled="loading"
                                    color="secondary"
                                    @click="findCep"
                                >Buscar
                                </v-btn>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-radio-group>
                                    <v-radio
                                        v-on:click="geoAddressEmitter(response)"
                                        v-for="(response, i) in geoApiResponse"
                                        :key="i"
                                        :label="`${response.formatted_address}`"
                                        :value="response"
                                        v-model="geoApiAddress"
                                    ></v-radio>
                                </v-radio-group>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="closeAlert()">
                        Cancelar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>
<script>
import geoApi from "@/services/geoapi";

export default {
    data() {
        return {
            showModal: false,
            loading: false,
            disabled: false,
            address: '',
            geoApiResponse: [],
            geoApiAddress: [],
            resultStatus: '',
        }
    },
    methods: {
        showFindCep() {
            this.showModal = true
        },
        findCep() {
            this.loading = true
            this.disabled = true
            geoApi.get(`json?address=${this.address}`).then(response => {
                this.geoApiResponse = response.data.results
                this.loading = false
                this.disabled = false
                this.resultStatus = response.data.status
                setTimeout(this.hideAlert, 30000)
            }).catch(() => {
                this.loading = false
                this.disabled = false
            })
        },
        hideAlert(){
            this.resultStatus = ''
        },
        geoAddressEmitter(response){
            this.$emit('geoApiAddress', response)
            this.showModal = false
        },
        closeAlert(){
            this.showModal = false
            this.resultStatus = ''
        }
    }
}
</script>
