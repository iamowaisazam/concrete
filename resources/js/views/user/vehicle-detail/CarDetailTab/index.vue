<template>
    <v-row no-gutters>
        <v-col cols="12" class="mt-3 ">
            <v-card>
                <div class="pa-5">
                    <v-row>
                        <v-col cols="12" lg="6" md="6" sm="12" class="d-flex flex-column justify-start">
                            <CarSlider />
                        </v-col>
                        <v-col cols="12" lg="6" md="6" sm="12" class="ps-5 pr-5">
                            <BasicInfo />
                        </v-col>
                    </v-row>
                </div>
                <div>
                    <Counter />
                </div>
            </v-card>

        </v-col>
    </v-row>

    <v-row class="mt-3 ">
        <v-col cols="12" md="8">
            <CarOverview />
        </v-col>
        <v-col cols="12" md="4">
            <Service />
        </v-col>
    </v-row>

    <!-- <v-row  class="">
        <v-col cols="12" md="8">
            <AdditionalInfo/>
        </v-col>
         <v-col cols="12" md="4">
             
        </v-col>
    </v-row> -->

    <v-row class="mt-3">
        <v-col cols="12" md="8">
            <Equipment />
        </v-col>
        <v-col cols="12" md="4">

        </v-col>
    </v-row>


    <v-row class="mt-2">
        <v-col cols="12" md="8">
            <Features />
        </v-col>
        <v-col cols="12" md="4">

        </v-col>
    </v-row>
</template>

<script>

import { useVehicleStore } from '@/stores/vehicleStore';
import CarSlider from './CarSlider.vue';
import CarOverview from './CarOverview.vue';
import BasicInfo from './BasicInfo.vue';
import Counter from './Counter.vue';
import AdditionalInfo from './AdditionalInfo.vue';
import Features from './Features.vue';
import Equipment from './Equipment.vue';
import Service from './Service.vue';


export default {
    components: {
        CarSlider,
        CarOverview,
        BasicInfo,
        Counter,
        AdditionalInfo,
        Features,
        Equipment,
        Service
    },
    data() {
        return {
            vehicleStore: useVehicleStore(),
            loading: false,
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

<style scoped>
/* Vuetify’s internal wrapper override */
::-webkit-scrollbar {
    display: none;
}

.mobile-panel {
    max-width: 280px;
}
</style>