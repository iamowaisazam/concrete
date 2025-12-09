<template>
        <div class="d-flex justify-space-between align-items-center w-100 "  >
            <div class="w-100 pr-2" >
                    <p class="pb-2" >From</p>
                    <custom-select 
                    class="w-100 d-block bg-background text-white px-5 py-2 rounded "
                    placeholder="From"
                    :data="mileageFrom"
                    defaultValue=""
                    @change="hanldeMileageFrom" 
                    />
            </div>
            <div class="w-100 px-2" > 
            <p class="pb-2" >To</p>
                <custom-select 
                    class="d-block bg-background text-white px-5 py-2 rounded w-100"
                    placeholder="To"
                    :data="mileageTo"
                    defaultValue=""
                    @change="hanldeMileageTo" 
                    />
            </div>
        </div>
</template>

<script>

import { useAuctionStore } from "@/stores/auctionStore";
import { useMasterStore } from "@/stores/masterStore";

export default {
   
    data() {
        
        return {
            auctionStore: useAuctionStore(),
            masterStore: useMasterStore(),
            mileageFrom: [
                { label: '0', id:0},
                { label: '20,000', id: 20000 },
                { label: '30,000', id: 30000 },
                { label: '40,000', id: 40000 },
                { label: '50,000', id: 50000 },
            ],
            mileageTo: [
                { label: '10,000', id: 10000 },
                { label: '20,000', id: 20000 },
                { label: '30,000', id: 30000 },
                { label: '40,000', id: 40000 },
                { label: '50,000', id: 50000 },
            ]
        }
    },
    methods: {
         hanldeMileageFrom(e) {
            this.auctionStore.filter.mileageFrom = e.target.value;
            this.auctionStore.getAuctionList();
        },
         hanldeMileageTo(e) {
            this.auctionStore.filter.mileageTo = e.target.value;
            this.auctionStore.getAuctionList();
        }
    },
   
};

</script>


<style>




</style>