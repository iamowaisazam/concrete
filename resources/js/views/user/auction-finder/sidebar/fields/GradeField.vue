<template>
    <div v-for="item in masterStore.grades.data" :key="item.id">
           <v-checkbox
             @change="handleChange" 
             v-model="auctionStore.filter.grade" 
             :label="String(item.label)" 
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
        }
    },
    computed: {
      
    },
};

</script>