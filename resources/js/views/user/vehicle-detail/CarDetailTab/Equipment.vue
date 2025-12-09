<template>
    <v-card title="Equipments">
        <div class="border"></div>
        <v-container>
            <v-row dense>
                <v-col v-for="value in equipments" :key="value" cols="6" sm="4" class="text-caption">
                    <v-chip variant="text" prepend-icon="mdi-circle-small">{{ value }}</v-chip>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>
<script>

import { useVehicleStore } from '@/stores/vehicleStore';

export default {
    components: {

    },
    data() {
        return {
            vehicleStore: useVehicleStore(),
        };
    },
    computed: {
        equipments() {

            let equipments = this.vehicleStore.vehicle?.equipment?.split(",") || [];            
            return equipments;

        },  
    },
    mounted() {
        
    },
    beforeUnmount() {

    },
    methods: {

    },
};

</script>