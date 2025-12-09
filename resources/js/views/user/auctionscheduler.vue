<template>
    <user-title-bar 
        title="Auction Scheduler" 
        subtitle="Manage and view platform auctions across all centers in one place.">
        <div class="d-flex flex-column flex-sm-row ga-2 w-100 w-md-75 w-lg-50 justify-center justify-sm-start align-start pr-5 pr-sm-0">
            <PlateformDropdown
                label="Select Platform"
                variant="outlined"
                :model-value="options.platform_id"
                @update:modelValue="handleInput($event,'platform_id')"
                clearable
                />
            <CenterDropdown
                label="Select Center"
                variant="outlined"
                :model-value="options.center_id"
                @update:modelValue="handleInput($event,'center_id')"
                clearable
                />
            <v-switch 
                model-value="options.enableCurrent" 
                color="primary"
                density="compact"  
                hide-details
                @change="handleInput($event,'enableCurrent')" 
                class="ml-3" 
                /> 
        </div>
        <div class="pt-4 d-flex align-center ga-4 flex-wrap ml-auto mr-auto">
            <div v-for="(value, key, index) in days" :key="index" :class="{ 'active': options.day == key}"
                class="border rounded bg-surface-variant-1 pa-3 ps-5 d-flex flex-column mb-3"
                style=" height: 95px; width: 195px;" @click="handleTab(key)">
                <div class="text-caption d-flex align-center justify-center border-b border-border pb-2 pt-2 text-wrap"
                    style="white-space: wrap !important;">
                    {{ key.toUpperCase() }}
                </div>
                <div class="lowerSection d-flex justify-space-between mt-2">
                    <div class="d-flex align-center">
                        <small><v-icon color="primary" icon="mdi-hammer" size="small"></v-icon></small>
                        <span class="pl-1 text-caption ">{{ value.auction }}</span>
                    </div>
                    <div class="d-flex align-center" >
                        <small class=" icon"><v-icon color="#00bad1" icon="mdi-car" size="small"></v-icon></small>
                        <span class="pl-1 text-caption ">{{ value.car }}</span>
                    </div>
                </div>
            </div>
        </div>
    </user-title-bar>

    <v-container fluid>
        <v-row class="mt-3" >
            <v-col cols="12" >
                    <v-card>
                        <v-data-table-server 
                        :headers="headers" 
                        :items="data" 
                        :items-length="total"
                        :loading="loading" 
                        item-value="id" 
                        @update:options="getRecords">

                            <template #item.action="{ item }">
                                <v-btn > <v-icon>mdi-eye</v-icon></v-btn>
                            </template>

                            <template v-slot:bottom>
                                <div class="py-2" >
                                    <custom-pagination
                                    :loading="loading"
                                    v-model:page="options.page" 
                                    :lastPage="options.last_page"
                                    @page-changed="getRecords"
                                    />
                                </div>
                            </template>

                        </v-data-table-server>
                </v-card>        
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

import { auctionSheldulerList } from '@/services/pageService';
import { usePageStore } from '@/stores/pageStore';

import PlateformDropdown from '@/components/PlateformDropdown.vue';
import CenterDropdown from '@/components/CenterDropdown.vue';

export default {
    props: {
        
    },
    components: {
        PlateformDropdown,
        CenterDropdown
    },
    data() {
        return {
            pageStore:usePageStore(),
            platforms: [],
            centers: [],
            days: {
                today: {
                    auction:0,
                    car:10,
                },
                mon: {
                    auction:0,
                    car:10,
                },
                tue: {
                    auction:6,
                    car:10,
                },
                wed: {
                    auction:0,
                    car:10,
                },
                thu: {
                    auction:9,
                    car:10,
                },
                fri: {
                    auction:0,
                    car:10,
                },
                sat: {
                    auction:10,
                    car:10,
                },
            },
            options: {
                length: 10,
                page: 1,
                last_page:1,
                offset: 0,
                platform_id: null,
                center_id: null,
                day: 'today',
                enableCurrent: false,
                date:'',
            },
            data: [],
            total: 0,
            loading:false,
            headers: [
                { title: "Platform", key: "platform_name" ,sortable:false},
                { title: "Center", value: "center_names" },
                { title: "Total Vehicles", value: "car_count" },
                { title: "Time", value: "time" },
                { title: "Status", value: "status" },
                { title: "Action", key: "action",sortable:false },
            ],
        };
    },
    async mounted() {

      
    },
    methods: {
        async handleInput(value,field) {

            switch (field) {
                case 'platform_id':
                          this.options.platform_id = value;
                    break; 
                case 'center_id':
                          this.options.center_id = value;
                    break;
                case 'enableCurrent':
                    console.log(value.target.checked);
                    if (value.target.checked) {
                        this.options.day = 'today';
                    }
                    this.options.enableCurrent = value.target.checked;

                    break;
            
                default:
                    break;
            }

            this.getRecords();
        },
        handleTab(key) {
         
            if(this.options.enableCurrent){
               
            } else {
                this.options.day = key;
            }

            this.getRecords();
        },
        async getRecords() {

           try {

               let res = await auctionSheldulerList(this.options);
               this.data = res.data;
               this.total = res.recordsTotal;
               this.options.page = Number(res.page);
               this.options.offset = res.offset;
               this.options.last_page = res.last_page
            } catch (error) {
               this.alertStore.add(error.message, 'error');
               this.data = [];
               this.total = 0;
               this.options.page = 1;
               this.options.last_page = 1;
            }    
       }
        
    },
};
</script>

<style scoped>

    .icon{
        font-size: 10px; 
        color: #00bad1;
    }

    .active{
        border-color: rgb(var(--v-theme-primary))!important;
    }

</style>
