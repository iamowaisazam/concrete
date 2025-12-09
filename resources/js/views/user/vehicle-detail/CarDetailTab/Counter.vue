<template>
    <v-row no-gutters class="d-flex align-center justify-center ga-1 bg-surface border-t  pt-8 pb-8 ">
        <v-col cols="6" lg="2" md="2" sm="3"
            class="d-flex align-center flex-column flex-sm-row ga-2">
            <v-btn color="primary" variant="tonal" icon="mdi-calendar" ></v-btn>
            <div class="d-flex flex-column ga-1">
                <p class="text-caption">{{ vehicleStore.vehicle.reg}}</p>
                <p class="text-caption mt-n1">Reg</p>
            </div>
        </v-col>
        <v-col cols="6" lg="2" md="2" sm="3"
            class="d-flex align-center flex-column flex-sm-row ga-2">
            <v-btn color="primary" variant="tonal" icon="mdi-calendar" ></v-btn>
            <div class="d-flex flex-column ga-1">
                <p class="text-caption">{{ vehicleStore.vehicle.dor }}</p>
                <p class="text-caption mt-n1">DOR</p>
            </div>
        </v-col>
        <v-col cols="6" lg="2" md="2" sm="3"
            class="d-flex align-center flex-column flex-sm-row ga-2">
            <v-btn color="primary" variant="tonal" icon="mdi-speedometer-medium" ></v-btn>
            <div class="d-flex flex-column ga-1">
                <p class="text-caption">{{ vehicleStore.vehicle.mileage }}</p>
                <p class="text-caption mt-n1">Mileage</p>
            </div>
        </v-col>
        <v-col cols="6" lg="2" md="2" sm="3"
            class="d-flex align-center flex-column flex-sm-row ga-2">
            <v-btn color="primary" variant="tonal" icon="mdi-creation-outline" ></v-btn>
            <div class="d-flex flex-column ga-1">
                <p class="text-caption">{{ vehicleStore.vehicle.grade }}</p>
                <p class="text-caption mt-n1">Grade</p>
            </div>
        </v-col>
        <v-col cols="6" lg="2" md="2" sm="3"
            class="d-flex align-center flex-column flex-sm-row ga-2">
            <v-btn color="primary" variant="tonal" icon="mdi-file-document" ></v-btn>
            <div class="d-flex flex-column ga-1">
                <p class="text-caption">{{ vehicleStore.vehicle.v5 }}</p>
                <p class="text-caption mt-n1">V5</p>
            </div>
        </v-col>
    </v-row>
</template>
<script>
    import {
        useVehicleStore
    } from '@/stores/vehicleStore';


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
