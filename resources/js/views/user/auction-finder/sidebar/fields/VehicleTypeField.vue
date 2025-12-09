<template>
    <div v-for="item in masterStore.vehicleTypes.data" :key="item.id">
           <v-checkbox 
             v-model="auctionStore.filter.vehicleType" 
             :label="item.label" 
             :value="item.id"
             @change="handleChange"
             />
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
            this.auctionStore.getAuctionList();        
        }
       
    },
    computed: {
      
    },
};

</script>