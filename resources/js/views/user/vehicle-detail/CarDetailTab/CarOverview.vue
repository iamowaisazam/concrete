<template>
    <custom-card title="Overview" >
        <v-container fluid>
            <!-- <v-row>
                <v-card-title class="text-h4 font-weight-medium">Overview</v-card-title>
            </v-row> -->
            <v-row>
                <v-col v-for="item in items" cols="6" sm="4" lg="3" >
                    <p class="ml-2 text-body-1 text-light text-overline text-capitalize">{{ item.title }}</p>
                    <v-chip  variant="text" size="large" :prepend-icon="item.icon">
                            <template #prepend>
                            <v-icon color="primary">{{ item.icon }}</v-icon>
                        </template>
                        {{ item.value }}</v-chip>
                            
                </v-col>
            </v-row>
        </v-container>
    </custom-card>
    
</template>

<script>
import { useVehicleStore } from '@/stores/vehicleStore';


export default {
    components: {

    },
    data() {
        return {
            vehicleStore: useVehicleStore(),
        };
    },
    computed:{
        items() {

            return [
                {
                    title: 'Vehicle Type',
                    value: this.vehicleStore.vehicle?.vehicleType?.name,
                    icon: 'mdi-car',
                    color:'red',
                },
                {
                    title: 'Make',
                    value: this.vehicleStore.vehicle?.make?.name,
                    icon: 'mdi-steering',
                    color:'primary',
                },
                {
                    title: 'Model',
                    value: this.vehicleStore.vehicle?.model?.name,
                    icon:'mdi-car-cog',
                },
                {
                    title: 'Variant',
                    value: this.vehicleStore.vehicle?.variant?.name,
                    icon:'mdi-cards',
                },
                {
                    title: 'CC',
                    value: this.vehicleStore.vehicle.cc,
                    icon:'mdi-speedometer-medium',
                },
                {
                    title: 'Year',
                    value: this.vehicleStore.vehicle.year,
                    icon:'mdi-calendar',
                },
                {
                    title: 'Color',
                    value: this.vehicleStore.vehicle?.color?.name,
                    icon:'mdi-palette',
                },
                {
                    title: 'Fuel Type',
                    value: this.vehicleStore.vehicle.fuel_type,
                    icon:'mdi-gas-station',
                },
                {
                    title: 'Transmission',
                    value: this.vehicleStore.vehicle.transmission,
                    icon:'mdi-cogs',
                },
                {
                    title: 'Keys',
                    value: this.vehicleStore.vehicle.keys,
                    icon:'mdi-key',
                },
                {
                    title: 'Doors',
                    value: this.vehicleStore.vehicle.doors,
                    icon:'mdi-door',
                },
                {
                    title: 'Seats',
                    value: this.vehicleStore.vehicle.seats,
                    icon:'mdi-seat-passenger',
                },
                {
                    title: 'Former Keepers',
                    value: this.vehicleStore.vehicle.former_keepers,
                    icon:'mdi-account-group',
                },
                {
                    title: 'Vendors',
                    value: this.vehicleStore.vehicle.seats,
                    icon:'mdi-file-account-outline',
                },
                {
                    title: 'VAT Type',
                    value: this.vehicleStore.vehicle.vat_status,
                    icon:'mdi-ticket-percent',
                },
                {
                    title: 'Euro Status',
                    value: this.vehicleStore.vehicle.euro_status,
                    icon:'mdi-leaf',
                },
                {
                    title: 'Engine Runs',
                    value: this.vehicleStore.vehicle.engine_runs,
                    icon:'mdi-car-wrench',
                }
            ]
        }
    },
    mounted() {


    },

    beforeUnmount() {

    },
    methods: {


    },

};
</script>

<style scoped>

</style>