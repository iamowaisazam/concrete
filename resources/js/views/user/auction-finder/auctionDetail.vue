<template>
    <div class="bg-surface rounded border pa-4">
         <v-data-table-server class="dataTable rounded" 
            :headers="headers" 
            :items="auctionStore.data"
            :items-length="auctionStore.total" 
            :loading="auctionStore.loading"
            item-value="id"   
            @update:options="auctionStore.getAuctionList">
                <template #item.make_name="{ item }">
                    <v-btn variant="plain" :to="'/user/vehicle-detail/'+item.id" >{{ item.make_name }} {{ item.model_name }} {{ item.variant_name }}</v-btn>
                    
                </template>
                <template #item.date="{ item }">
                    {{ item.auction_date }} {{ item.auction_time }}
                </template>
                <template v-slot:bottom>
                    <custom-pagination
                      :loading="auctionStore.loading"
                      v-model:page="auctionStore.filter.page" 
                      :lastPage="auctionStore.last_page"
                      @page-changed="auctionStore.getAuctionList"
                      />
                </template>
        </v-data-table-server>
    </div>
</template>

<script>

import { useAuctionStore } from "@/stores/auctionStore";

export default {
    components: {
    },
    data() {
        return {
            auctionStore: useAuctionStore(),
            headers: [
                {
                    title: "Vehicle",
                    key: "make_name",
                    sortable: false
                },
                {
                    title: "Year / CC",
                    key: "cc"
                },
                {
                    title: "Mileage",
                    key: "mileage"
                },
                {
                    title: "Transmission",
                    key: "transmission"
                },
                {
                    title: "Grade",
                    key: "grade"
                },
                {
                    title: "Date Time",
                    key: "date"
                },
                {
                    title: "Auction House",
                    key: "auction_name"
                },
            ],
         
        }
    },
    computed: {
      
       
    },
    methods: {
      
    },
};

</script>


<style>




</style>
