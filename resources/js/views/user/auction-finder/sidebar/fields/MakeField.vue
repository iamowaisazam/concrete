<template>
    <div v-for="item in masterStore.makes.data" :key="item.id">
           <v-checkbox 
             v-model="auctionStore.filter.make" 
             :label="item.label"
             @change="handleChange" 
             :value="item.id" />
    </div>
</template>

<script>

import { useAuctionStore } from "@/stores/auctionStore";
import { useMasterStore } from "@/stores/masterStore";

export default {
    components: {
    },
    data() {
        return {
            auctionStore: useAuctionStore(),
            masterStore:useMasterStore(),
        }
    },
    methods: {
        handleChange(e) {
            
            this.auctionStore.filter.model = [];
            this.auctionStore.filter.variant = [];
            this.masterStore.variants.data = [];
            this.masterStore.getModels({
                make:this.auctionStore.filter.make,
            });
            
            this.auctionStore.getAuctionList();

        }
    },
    computed: {
      
    },
};

</script>