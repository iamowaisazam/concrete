<template>
    <user-title-bar title="Reauction Tracker"
        subtitle="Monitor unsold lots making a comeback — compare prices, bids, and market movement.">
        
        <!-- <v-container class="contentArea d-flex align-center justify-start pb-0 ga-6 mb-n6 mb-sm-n5" fluid>
          
            <v-card class="redBox d-flex align-center justify-center flex-column ga-2 bg-danger  mb-n3"
                elevation="0">
                <v-card-title class="redBox-figure text-h2 text-white">0</v-card-title>
                <v-card-subtitle class="redBox-date text-body-2 text-white">Today</v-card-subtitle>
            </v-card>

            <v-card color="transparent" class="d-flex align-center justify-center flex-column ga-1" elevation="0">

                <v-row class="auction-house d-flex align-baseline justify-space-around ga-1 ga-sm-3" >
                    <v-col cols="auto">
                        <p>Auction House</p>
                    </v-col>
                    <v-col cols="auto">
                        <div class="wrapper bg-shadow pa-3 rounded flex-wrap">No Platforms</div>
                    </v-col>
                </v-row>

                <v-row class="auction-center d-flex align-baseline justify-space-around ga-5">
                    <v-col cols="auto">
                        <p>Auction Center</p>
                    </v-col>
                    <v-col cols="auto">
                        <div class="wrapper bg-shadow pa-3 rounded flex-wrap">No Centers</div>
                    </v-col>
                </v-row>
            </v-card>
        </v-container> -->
    </user-title-bar>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <div class="pt-5 d-flex justify-md-space-between flex-wrap ">            
                    <div class="d-flex flex-wrap">
                            <div class="px-2" >
                                <v-select 
                                    label="Length"
                                    v-model="pageStore.reauction.length"
                                    :items="[10,20,50,100,200,500]" 
                                    @update:model-value="handleInput"
                                    variant="outlined"
                                    color="primary" 
                                    width="120" 
                                    density="compact" 
                                    />
                            </div>
                            <div class="align-self-center pl-2" >
                                  {{pageStore.reauction.offset}} - {{(pageStore.reauction.offset + pageStore.reauction.length)}} of {{ pageStore.reauction.total }} Vehicles
                            </div>
                           
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="px-2" >
                            <v-text-field 
                                prepend-inner-icon="mdi-magnify"
                                label="Reg No" 
                                v-model="pageStore.reauction.reg"
                                @update:model-value="handleInput"
                                variant="outlined"
                                color="primary" 
                                width="200" 
                                density="compact" 
                                clearable />
                        </div>   
                    </div>
                </div>
            </v-col>

            <v-col cols="12">
                <v-card>
                       <div class="bg-surface" >
                            <v-data-table-server 
                            :headers="headers" 
                            :items="pageStore.reauction.data" 
                            :items-length="pageStore.reauction.total"
                            :loading="pageStore.reauction.loading" 
                            item-value="id" 
                            @update:options="pageStore.getreAuctionList">
                            
                                <template #item.action="{ item }">
                                    <v-btn :to="'/user/vehicle-detail/'+item.id"> <v-icon>mdi-eye</v-icon></v-btn>
                                </template>
                            
                                <template v-slot:bottom>
                                    <div class="pt-2" >
                                        <custom-pagination
                                        :loading="pageStore.reauction.loading"
                                        v-model:page="pageStore.reauction.page" 
                                        :lastPage="pageStore.reauction.last_page"
                                        @page-changed="pageStore.getreAuctionList"
                                        />
                                    </div>
                                </template>

                            </v-data-table-server>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>


import { usePageStore } from "@/stores/pageStore";

export default {
    props: {},
    components: {
     
    },
    data() {

        return {
            pageStore:usePageStore(),
            headers: [
                { title: "Name", value: "title" },
                { title: "Make", value: "make_name" },
                { title: "Vehicle", value: "model_name" },
                { title: "Reg", value: "reg" },
                { title: "Previous", value: "last_bid" },
                { title: "Platform", value: "platform_name" },
                { title: "Center", value: "center_name" },
                { title: "Cap Clean", value: "cap_clean" },
                { title: "Cap Average", value: "cap_average" },
                { title: "Mileage", value: "mileage" },
                { title: "Status", value: "bidding_status" },
                { title: "Time", value: "auction_date" },
                { title: "Action", value: "action", sortable: false },
            ],
        }
    },
    async mounted() {

      
    },
    methods: {
        handleInput(e) {
             this.pageStore.getreAuctionList();
        },
    },
};
</script>

<style>

</style>
