<template>
    <user-title-bar title="Smart Auction Search"
        subtitle="Filter, compare, and uncover vehicles that match your profit goals.">
        <div class="d-flex align-center ga-3">

            <v-btn variant="tonal" class="text-none px-5 py-2"
                :class="{ 'bg-primary text-white': auctionStore.auctionTab === true}" 
                @click="auctionStore.toggleAuctionTab()"> Auction Finder </v-btn>

            <v-btn variant="tonal" class="text-none px-5 py-2" :class="{ 'bg-primary text-white': auctionStore.auctionTab === false}" 
            @click="auctionStore.toggleAuctionTab()"> Vehicle Valuation</v-btn>

        </div>
    </user-title-bar>

    <v-container fluid>
        <v-row class="mt-3" >
            <v-col cols="12 " >
                <div class="mr-auto ml-auto ">
                    <div class="pb-3 d-flex align-center justify-space-between">
                        <div class="d-flex w-100 flex-wrap" >
                            <div class="px-3"  >
                                <v-btn 
                                v-if="auctionStore.sidebar"
                                color="primary" 
                                variant="outlined" 
                                prepend-icon="mdi-filter" 
                                @click="auctionStore.toggleFilter()"></v-btn>

                                <v-btn v-else
                                color="primary" 
                                variant="outlined" 
                                prepend-icon="mdi-filter-off" 
                                @click="auctionStore.toggleFilter()"></v-btn>

                                
                            </div>
                            <div class="px-3"  style="width: 130px;" >
                                <v-select 
                                persistent-placeholder 
                                v-model="auctionStore.filter.length"
                                @update:model-value="handleInput()" 
                                color="primary" 
                                variant="outlined" 
                                density="compact" 
                                label="Length"
                                :items="[10,50,100,200,500]" />
                            </div>
                            <div class="px-3"  style="width: 300px;" >
                                <v-select 
                                    persistent-placeholder 
                                    v-model="auctionStore.filter.sort_by"
                                    @update:model-value="handleInput()"  
                                    color="primary" 
                                    variant="outlined" 
                                    density="compact" 
                                    item-title="name"
                                    item-value="id"     
                                    label="Sort by"
                                    :items="sortingOptions" />
                            </div>
                            <div class="px-3">
                                <v-btn 
                                color="danger"
                                class="mx-2" 
                                variant="outlined" 
                                prepend-icon="mdi-delete" 
                                @click="this.auctionStore.ClearFilter()" />

                                <v-btn 
                                color="primary" 
                                variant="outlined" 
                                prepend-icon="mdi-magnify" 
                                @click="handleSearch" />
                            </div>
                            <div class="px-3 ">
                                {{auctionStore.offset}} - {{(auctionStore.offset + auctionStore.filter.length)}} of {{ auctionStore.total }} Vehicles
                            </div>
                        </div>
                    </div>

                    <div :class="{'sidebarOpen': auctionStore.sidebar }" class="main-div d-flex align-start justify-space-between flex-wrap">
                            <div class="sidebar" >
                                <div class=" bg-surface rounded border pa-4">
                                    <auctionSidebar/>
                                </div>   
                            </div> 
                            <div class="transition-col">
                                <component :is="currentComponent" />
                            </div>
                        </div>

                </div>


            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import AuctionFinder from "./auctionDetail.vue";
import VehicleValuation from "./vehicleValuation.vue";
import auctionSidebar from "./sidebar/index.vue";
import { useAuctionStore } from "@/stores/auctionStore";

export default {
    components: {
        AuctionFinder,
        VehicleValuation,
        auctionSidebar
    },
    data() {
        return {
            auctionStore:useAuctionStore(),
        };
    },
    mounted() {
      
        this.auctionStore.loadSiderBarFilters(); 
        // this.auctionStore.getAuctionList();  
        this.$themeStore.menuType = 'collapsed';

    },
     computed: {
        sortingOptions() {
            return [
                { id: 'name-asc', name: 'Name: A to Z' },
                { id: 'name-dsc', name: 'Name: Z to A' },
                { id: 'grade-desc', name: 'Grade: Low to High' },
                { id: 'grade-asc', name: 'Grade: High to Low' },
                { id: 'date-desc', name: 'Date & Time: Oldest First' },
                { id: 'date-asc', name: 'Date & Time: Newest First' }
            ];
        },
        currentComponent() {
            return this.auctionStore.auctionTab  ? "AuctionFinder" : "VehicleValuation";
        },
    },
    methods: {
        handleInput() {
            this.auctionStore.getAuctionList()
        },
        handleSearch() {
            this.auctionStore.getAuctionList();
        }
    },
   
    
};
</script>

<style scoped>

.main-div{
    position: relative;
}

.sidebar{
    width: 300px;
    display: none;
    /* overflow: scroll; */
    /* max-height: 700px; */

}

.transition-col{
    width: 100%;
}

.sidebarOpen .sidebar{
    width: 330px!important;
    display: block;
}

.sidebarOpen .transition-col{
     width: calc( 100% - 350px)!important;
}

@media (max-width: 786px) {
    
    .sidebarOpen .transition-col{
     width: 100%!important;
    }

    .sidebar{
        position: absolute;
        left: 0;
    }

}



</style>
