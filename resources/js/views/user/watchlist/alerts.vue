<template>


   
</template>

<script>

import { useMasterStore } from "@/stores/masterStore";
import { useVehicleStore } from "@/stores/vehicleStore";


export default {
    name: "Watchlist",
    components: {
       
    },
    data() {
        return {
            vehicleStore: useVehicleStore(),
            masterStore: useMasterStore(),
           
        };
    },
    methods: {
        async loadItems() {
         
        },
    },
};
</script>

<style scoped >

</style>
