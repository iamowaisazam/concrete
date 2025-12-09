<template>
        <div>
            <v-expansion-panels>

                <v-expansion-panel :disabled="masterStore.vehicleTypes.data.length ? false : true" title="Vehicle Type">
                    <v-expansion-panel-text>
                        <VehicleTypeField/>
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.vehicleTypes.data" 
                        :compareValue="auctionStore.filter.vehicleType" 
                        removeKey="vehicleType"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                
                <v-expansion-panel :disabled="masterStore.makes.data.length ? false : true" title="Make">
                    <v-expansion-panel-text>
                        <MakeField/>
                    </v-expansion-panel-text>
                     <Chip 
                        :data="masterStore.makes.data" 
                        :compareValue="auctionStore.filter.make" 
                        removeKey="make"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                
                <v-expansion-panel :disabled="masterStore.models.data.length ? false : true" title="Model" size="x-small" >
                    <v-expansion-panel-text>
                        <ModelField/>
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.models.data" 
                        :compareValue="auctionStore.filter.model" 
                        removeKey="model"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                
                <v-expansion-panel :disabled="masterStore.variants.data.length ? false : true" title="Model Variant">
                    <v-expansion-panel-text>
                        <VariantField/>
                    </v-expansion-panel-text>
                     <Chip 
                        :data="masterStore.variants.data" 
                        :compareValue="auctionStore.filter.variant" 
                        removeKey="variant"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>

                <v-expansion-panel :disabled="masterStore.platforms.data.length ? false : true" title="Auction House">
                    <v-expansion-panel-text>
                        <PlatformField/>
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.platforms.data" 
                        :compareValue="auctionStore.filter.platform" 
                        removeKey="platform"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>

                <v-expansion-panel :disabled="masterStore.centers.data.length ? false : true" title="Auction Center">
                    <v-expansion-panel-text>
                        <CenterField/>
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.centers.data" 
                        :compareValue="auctionStore.filter.center" 
                        removeKey="center"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>

                <v-expansion-panel :disabled="masterStore.years.data.length ? false : true" title="Years">
                    <v-expansion-panel-text>
                          <YearField/>
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.years.data" 
                        :compareValue="auctionStore.filter.year" 
                        removeKey="year"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>

                <v-expansion-panel title="Transmission" :disabled="masterStore.transmissions.data.length ? false : true">
                    <v-expansion-panel-text>
                       <TransmissionField />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.transmissions.data" 
                        :compareValue="auctionStore.filter.transmission" 
                        removeKey="transmission"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>

                <v-expansion-panel :disabled="masterStore.fuelType.data.length ? false : true" title="Fuel Type">
                    <v-expansion-panel-text>
                        <FuelTypeField />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.fuelType.data" 
                        :compareValue="auctionStore.filter.fuelType" 
                        removeKey="fuelType"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                <v-expansion-panel :disabled="masterStore.doors.data.length ? false : true" title="Doors">
                    <v-expansion-panel-text>
                         <DoorField />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.doors.data" 
                        :compareValue="auctionStore.filter.door" 
                        removeKey="door"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                <v-expansion-panel :disabled="masterStore.seats.data.length ? false : true" title="Seats">
                    <v-expansion-panel-text>
                         <SeatField />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.seats.data" 
                        :compareValue="auctionStore.filter.seat" 
                        removeKey="seat"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                <v-expansion-panel :disabled="masterStore.grades.data.length ? false : true" title="Grade">
                    <v-expansion-panel-text>
                      <GradeField />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.grades.data" 
                        :compareValue="auctionStore.filter.grade" 
                        removeKey="grade"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                <v-expansion-panel :disabled="masterStore.v5.data.length ? false : true" title="V5">
                    <v-expansion-panel-text>
                        <V5Field />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.v5.data" 
                        :compareValue="auctionStore.filter.v5" 
                        removeKey="v5"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                <v-expansion-panel :disabled="masterStore.cc.data.length ? false : true" title="Engine Size (CC)">
                    <v-expansion-panel-text>
                       <CCField />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.cc.data" 
                        :compareValue="auctionStore.filter.cc" 
                        removeKey="cc"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                <v-expansion-panel :disabled="masterStore.formerKeepers.data.length ? false : true" title="Former Keepers">
                    <v-expansion-panel-text>
                        <FormerKeeperField />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.formerKeepers.data" 
                        :compareValue="auctionStore.filter.formerKeeper" 
                        removeKey="formerKeeper"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                <v-expansion-panel :disabled="masterStore.noOfServices.data.length ? false : true" title="No. of Services">
                    <v-expansion-panel-text>
                      <NoOfServices />
                    </v-expansion-panel-text>
                    <Chip 
                        :data="masterStore.noOfServices.data" 
                        :compareValue="auctionStore.filter.noOfService" 
                        removeKey="noOfService"
                        :removeValue="auctionStore.removeValue" />
                </v-expansion-panel>
                <v-expansion-panel title="Mileage">
                    <v-expansion-panel-text>
                       <MilegueField />
                    </v-expansion-panel-text>
                </v-expansion-panel>
            </v-expansion-panels>
        </div>   
</template>

<script>

import { useAuctionStore } from "@/stores/auctionStore";
import { useMasterStore } from "@/stores/masterStore";


import VehicleTypeField from "./fields/VehicleTypeField.vue";
import PlatformField from "./fields/PlatformField.vue";
import MakeField from "./fields/MakeField.vue";
import ModelField from "./fields/ModelField.vue";
import VariantField from "./fields/VariantField.vue";
import CenterField from "./fields/CenterField.vue";
import YearField from "./fields/YearField.vue";
import TransmissionField from "./fields/TransmissionField.vue";
import FuelTypeField from "./fields/FuelTypeField.vue";
import DoorField from "./fields/DoorField.vue";
import SeatField from "./fields/SeatField.vue";
import GradeField from "./fields/GradeField.vue";
import V5Field from "./fields/V5Field.vue";
import CCField from "./fields/CCField.vue";
import FormerKeeperField from "./fields/FormerKeeperField.vue";
import NoOfServices from "./fields/NoOfServices.vue";
import MilegueField from "./fields/MilegueField.vue";

import Chip from "./fields/chip.vue";


export default {
    components: {
        PlatformField,
        VehicleTypeField,
        MakeField,
        ModelField,
        VariantField,
        CenterField,
        YearField,
        TransmissionField,
        FuelTypeField,
        DoorField,
        SeatField,
        GradeField,
        V5Field,
        CCField,
        FormerKeeperField,
        NoOfServices,
        MilegueField,
        Chip
    },
    data() {
        return {
            auctionStore: useAuctionStore(),
            masterStore:useMasterStore(),
        };
    },
    computed: {

    },
    methods: {
        handleChipClose(field,e) {
            
            console.log(e);
                
        }
    
    },
};
</script>

<style scoped>

</style>
