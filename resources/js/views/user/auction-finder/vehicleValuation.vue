<template>
    <div class="bg-surface rounded border pa-4">
          <v-data-table-server class="dataTable rounded" 
            :headers="headers" 
            :items="auctionStore.data"
            :items-length="auctionStore.total" 
            :loading="auctionStore.loading"
            item-value="id"   
            @update:options="auctionStore.getAuctionList">
                <template #item.vehicle="{ item }">
                    {{ item.make_name }} {{ item.model_name }} {{ item.variant_name }}
                </template>

                <template #item.date="{ item }">
                    {{ item.auction_date }} {{ item.auction_time }}
                </template>

                 <template #item.autoboli="{ item }">
                    
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
                    key: "vehicle",
                    sortable: false
                },
                {
                    title: "Grade",
                    key: "grade"
                },
                {
                    title: "Cap Clean",
                    key: "cap_clean"
                },
                {
                    title: "Cap Average",
                    key: "cap_average"
                },
                {
                    title: "Cap Below",
                    key: "cap_below"
                },
                {
                    title: "Autotrader Retail",
                    key: "autotrader_retail_value"
                },
                {
                    title: "Date Time",
                    key: "date"
                },
                {
                    title: "Autoboli",
                    key: "autoboli"
                },
            ],
         
        }
    },
    methods: {
       
    },
    computed: {
      
    },
};

</script>

