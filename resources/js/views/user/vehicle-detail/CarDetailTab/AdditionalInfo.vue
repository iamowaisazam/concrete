<template>

    <custom-card  title="Additional Information">
        <v-container fluid>
            <!-- <v-row>
                <v-card-title class="text-h4 font-weight-medium">
                    Additional Information
                </v-card-title>
            </v-row> -->
            <v-row>
                <v-col cols="6" sm="3">
                       <p class="ml-2 text-body-1 text-light text-overline text-capitalize">Former Keepers</p>
                        <v-chip variant="text" size="large" prepend-icon="mdi-account-group" >
                            <template #prepend>
                                <v-icon color="primary">mdi-account-group</v-icon> 
                            </template>
                            {{ vehicleStore.vehicle.former_keepers}}
                        </v-chip>
                </v-col>

                <v-col cols="6" sm="3">
                    <p class="ml-2 text-body-1 text-light text-overline text-capitalize">Vendors</p>
                    <v-chip variant="text" size="large" prepend-icon="mdi-file-account-outline" >
                        <template #prepend>
                            <v-icon color="primary">mdi-file-account-outline</v-icon> 
                        </template>
                        {{ vehicleStore.vehicle.vendor}}
                    </v-chip>
                </v-col>

                <v-col cols="6" sm="3">
                    <p class="ml-2 text-body-1 text-light text-overline">VAT Type</p>
                    <v-chip variant="text" size="large" prepend-icon="mdi-ticket-percent">
                        <template #prepend>
                        <v-icon color="primary">mdi-ticket-percent</v-icon>
                        </template>
                        {{ vehicleStore.vehicle.vat_status}}
                    </v-chip>
                </v-col>

                <v-col cols="6" sm="3">
                <p class="ml-2 text-body-1 text-light text-overline">Euro Status</p>
                <v-chip variant="text" size="large" prepend-icon="mdi-leaf">
                    <template #prepend>
                    <v-icon color="primary">mdi-leaf</v-icon>
                    </template>
                    {{ vehicleStore.vehicle.euro_status }}
                </v-chip>
                </v-col>

                <v-col cols="6" sm="3">
                <p class="ml-2 text-body-1 text-light text-overline">Engine Runs</p>
                <v-chip variant="text" size="large" prepend-icon="mdi-car-wrench">
                    <template #prepend>
                    <v-icon color="primary">mdi-car-wrench</v-icon>
                    </template>
                    {{ vehicleStore.vehicle.engine_runs}}
                </v-chip>
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