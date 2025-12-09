<template>
    <custom-card title="Service History" class="h-100">
      <v-container>
        <v-row>
            <v-col v-for="(item,key) in items"  cols="12" sm="6" class="text-body-2">
                <div class="px-2">

                    <p class="text-light">{{item.label }} </p>
                    <div class="d-flex pt-2" >
                        <v-icon color="primary">{{ item.icon }}</v-icon>
                        <span class="pl-3 text-body-2" >{{ item.value }}</span>
                    </div>

                    <!-- <v-chip  class="my-chip" variant="text" size="large" :prepend-icon="item.icon">
                        <template #prepend> <v-icon color="primary">{{ item.icon }}</v-icon></template>
                        {{ item.value }}
                    </v-chip> -->
                </div>
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
    computed: {
        items() {

            return [
                {
                    "label":  "Service History",
                    "value":  this.vehicleStore.vehicle.number_of_services_details,
                    "icon": "mdi-book-open-page-variant",
                    "type": "title"
                },
                {
                    "label": "Number of service",
                    "value": this.vehicleStore.vehicle.no_of_services,
                    "icon": "mdi-wrench",
                    "highlight": true
                },
                {
                    "label": "Last Service",
                    "value": this.vehicleStore.vehicle.last_service,
                    "icon": "mdi-calendar"
                },
                {
                    "label": "Last service mileage",
                    "value": this.vehicleStore.vehicle.mileage,
                    "icon": "mdi-speedometer",
                    "highlight": true
                },
                {
                    "label": "DVSA Mileage",
                    "value": this.vehicleStore.vehicle.dvsa_mileage,
                    "icon": "mdi-speedometer"
                },
                {
                    "label": "Additional service notes",
                    "value": this.vehicleStore.vehicle.number_of_services_details,
                    "icon": "mdi-note-text-outline"
                },
                {
                    "label": "MOT Expiry",
                    "value": this.vehicleStore.vehicle.mot_expiry_date,
                    "icon": "mdi-calendar-alert"
                }
            ]
        }

    },
    methods: {


    }

};

</script>

<style scope >

.my-chip{
    max-width: auto !important;       /* remove default Vuetify max-width */
    min-width: auto !important;          /* allow small chips if needed */
    white-space: normal !important;   /* allow wrapping */
    overflow: visible !important;     /* prevent clipping */
}


</style>