<template>
    <v-row class="mt-5 ">
        <v-col cols="12" md="4" class="">
            <v-card title="Vehicle Values" class="h-100">
                <v-container>
                    <div class="mb-8 text-capitalize">
                        <div class=" mb-4  text-capitalize">Trade Values</div>
                        <v-row align="center">
                            <v-col cols="6">
                                <div class="text-body-2 text-grey-lighten-1 mb-1">Autotrader</div>
                                <div class="text-body-2 text-white  mt-2">£{{ vehicleStore.vehicle.autotrader_trade_value}}</div>
                            </v-col>
                            <v-col cols="6">
                                <div class="text-body-2 text-light mb-1">CAP</div>
                                <div class="text-body-2 ">£{{ vehicleStore.vehicle.cap_average}}</div>
                            </v-col>
                        </v-row>
                        <v-divider class="my-6 border-opacity-50" color="grey-lighten-1" />
                    </div>

                    <!-- Retail Values -->
                    <div>
                        <div class="mb-4 text-capitalize">Retail Values</div>
                         <v-row align="center">
                            <v-col cols="6">
                                <div class="text-body-2 text-grey-lighten-1 mb-1">Autotrader</div>
                                <div class="text-body-2 text-white  mt-2">£{{ vehicleStore.vehicle.autotrader_retail_value}}</div>
                            </v-col>
                            <v-col cols="6">
                                <div class="text-body-2 text-light mb-1">CAP</div>
                                <div class="text-body-2 ">£{{ vehicleStore.vehicle.cap_retail}}</div>
                            </v-col>
                        </v-row>
                    </div>
                </v-container>
            </v-card>
        </v-col>
        <v-col cols="12" md="4" class="">
                <v-card class="h-100">
                    <v-container>

                        <!-- Top Row: Reg + New Report Button -->
                        <div class="d-flex align-center justify-space-between mb-3">
                            <div class="text-body-1 text-white font-weight-bold">{{ vehicleStore.vehicle.reg }}</div>
                            <v-btn color="primary" variant="flat" size="small">New Report</v-btn>
                        </div>

                        <!-- Car Details -->
                        <div class="text-body-2 text-light mb-4">{{ vehicleStore.vehicle.title}}</div>

                        <!-- Auction Info + Status -->
                        <div class="mb-4 d-flex justify-space-between">
                            <div>
                                <div class="text-body-2 text-light">Auction House</div>
                                <div class="text-body-2">{{ vehicleStore.vehicle?.auction?.name}}</div>
                            </div>
                            <div>
                                <div class="text-body-2 text-light">Date/End</div>
                                <div class="text-body-2 ">{{ vehicleStore.vehicle?.auction_date}}</div>
                            </div>
                            <div>
                                <div class="text-body-2 text-light">Status</div>
                                <div class="text-body-2 ">{{ vehicleStore.vehicle?.bidding_status}}</div>
                            </div>
                        </div>
                        <div>
                            <div>
                                <v-img :src="image" class="rounded-lg" cover /> 
                            </div>                            
                        </div>
                    </v-container>
                </v-card>
        </v-col>
        <v-col cols="12" md="4" class="">
            <custom-card >
                <v-container class="px-3">
                    <div class="text-body-2 text-capitalize text-light d-flex justify-space-between mb-3">
                        <p class="">CAP</p>
                        <p class="">90%</p>
                    </div>
                    <div class="text-body-2 text-capitalize text-light d-flex justify-space-between">
                        <p class="">AUTOTRADER</p>
                        <p class="">90%</p>
                    </div>
                </v-container> 
            </custom-card> 
            <custom-card  class="mt-5">
                <v-container class="px-3">
                    <h3 class="text-body-1 pb-5">Auction Results</h3>
                    <div class="text-body-2 text-capitalize text-light d-flex justify-space-between mb-3">
                        <p class="">Auction Status</p>
                        <p class="">{{ vehicleStore.vehicle?.bidding_status}}</p>
                    </div>
                    <div class="text-body-2 text-capitalize text-light d-flex justify-space-between mb-3">
                        <p class="text-body-2">Win Bid / Last Bid</p>
                        <p class="text-body-2">{{ vehicleStore.vehicle?.last_bid}}</p>
                    </div>
                    <div class="text-body-2 text-capitalize text-light d-flex justify-space-between">
                        <p class="">No. of Bids</p>
                        <p class="">{{ bidding_history.length }}</p>
                    </div>

                    <h3 class="text-body-1 text-light pt-6 pb-3">Auc Bid History</h3>
                    <p class="text-body-2">
                        <v-chip v-for="value in bidding_history" variant="tonal" color="primary" class="my-1 mx-1" > {{ value }} </v-chip>
                       
                    </p>
                </v-container>        
            </custom-card> 
        </v-col>
    </v-row>

    <v-row class="">
        <v-col cols="12" md="8">
            <TradeHistory/>
        </v-col>
    </v-row>

</template>

<script>

import { useVehicleStore } from '@/stores/vehicleStore';
import TradeHistory from './TradeHistory.vue';

export default {
    components: {
        TradeHistory,
    },
    data(){
        return {
            vehicleStore: useVehicleStore(),
            loading: false,
            image:'',
        };
    },
    mounted() {

        this.image = this.vehicleStore.vehicle?.images?.split(",")[0];
                //  console.log(this.bidding_history);
    },
    beforeUnmount() {

    },
    computed: {
         bidding_history() {

           
            
            let bidding_history = this.vehicleStore.vehicle?.bidding_history;

            bidding_history = bidding_history.replaceAll("[", "").replaceAll("]", "").replaceAll("'", "");
           
            bidding_history = bidding_history.split(", ") || [];

            return bidding_history;

        },

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