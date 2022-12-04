<template>
    <div>
        <v-row>
            <v-col cols="3" style="width: 10%">
                <v-btn class="mx-2" fab dark color="indigo">
                    <v-icon dark>
                        mdi-plusc
                    </v-icon>
                </v-btn>
                <v-list dense>
                    <v-list-item-group
                        v-model="selectedItem"
                        color="primary">
                        <v-list-item
                            v-for="(contact, i) in contacts"
                            :key="i"
                        >
                            <v-list-item-content>
                                <v-list-item-title v-text="contact.name"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>

            </v-col>
            <v-col cols="9">
                <gmap-autocomplete
                    @place_changed="setPlace"
                />
                <GmapMap
                    :center="{lat:-25.4437172 , lng:-49.2789859}"
                    :zoom="5"
                    style="width: 100%; height: 550px"
                >
                    <GmapMarker
                        :key="index"
                        v-for="(contact, index) in contacts"
                        :cursor="contact.marker"
                        :clickable="true"
                        :draggable="true"
                    />
                </GmapMap>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data() {
        return {
            contacts: [],
            selectedItem: null,
        }
    },
    methods: {
        setPlace(place) {
            if (!place) return
        }
    },
    mounted() {
        this.$http.get('contacts').then(responser => {
            this.contacts = responser.data
        })
    }
}
</script>
