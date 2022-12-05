<template>
    <div>
        <v-row>
            <v-col cols="3" style="width: 10%">
                <v-btn v-on:click="createNewContact" class="mx-2" fab dark color="indigo">
                    <v-icon dark>
                        mdi-plus
                    </v-icon>
                </v-btn>
                <v-list dense>
                    <v-list-item-group
                        v-model="selectedItem"
                        color="primary">
                        <v-list-item v-on:click="setCenter(contact.address)"
                                     v-on:dblclick="$refs.contactForm.contactEdit(contact, false)"
                                     v-for="(contact, i) in contacts"
                                     :key="i">
                            <v-list-item-content>
                                <v-list-item-title v-text="contact.name"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>

            </v-col>
            <v-col cols="9">
                <GmapMap
                    :center=this.center
                    :zoom="zoom"
                    style="width: 100%; height: 82vh;"
                >
                    <GmapMarker
                        v-for="(contact, index) in contacts"
                        :key="index"
                        :position='{lat: contact.address.lat ,lng: contact.address.lng}'
                        :clickable="true"
                    />
                </GmapMap>
            </v-col>
        </v-row>
        <ContactForm ref="contactForm" v-on:showModal="$emit('showModal')" />
        <ContactForm ref="createContact" v-on:showModal="$emit('showModal')" />
    </div>
</template>
<script>
import ContactForm from "@/components/ContactForm";
export default {
    components: {ContactForm},
    data() {
        return {
            contacts: [],
            zoom: 16,
            selectedItem: null,
            center: {lat: -25.4437172, lng: -49.2789859},
        }
    },
    methods: {
        setCenter(address) {
            this.zoom = 16
            this.center = {lat: address.lat, lng: address.lng}
        },
        createNewContact(){
            this.$refs.createContact.contactCreate()
        }
    },
    mounted() {
        this.$http.get('contacts').then(responser => {
            this.contacts = responser.data
        })
    }
}
</script>
