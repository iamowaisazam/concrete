<template>
    <custom-card title="Features">
        <v-container>
            <v-row dense>
                <v-col v-for="value in features" cols="6" sm="4" class="text-caption">
                    <v-chip variant="text" prepend-icon="mdi-circle-small" >{{ value }}</v-chip>
                </v-col>
            </v-row>
        </v-container>
    </custom-card>
</template>

<script>

import { useVehicleStore } from '@/stores/vehicleStore';

export default {
    components: {

    },
    computed: {
        features(){

            let features = this.vehicleStore.vehicle?.features?.split(",") || [];            
            return features;
        },
    },
    data() {
        return {
            vehicleStore: useVehicleStore(),
        };
    },
    mounted() {


    },

    beforeUnmount() {

    },
    methods: {


    },

};

</script>