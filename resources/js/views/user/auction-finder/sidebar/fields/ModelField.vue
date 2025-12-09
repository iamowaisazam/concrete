<template>
    <div v-for="item in masterStore.models.data" :key="item.id">
           <v-checkbox 
             v-model="auctionStore.filter.model" 
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

            this.auctionStore.getAuctionList();
            this.masterStore.getVariants({
                model:this.auctionStore.filter.model
            });
             
        }
    },
    computed: {
      
    },
};

</script>