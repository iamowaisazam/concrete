<template>

    <custom-card title="Auctions" class="h-100 "  >
        <div class="card-content " >
            <div class="py-2 px-2">

                    <PlateformDropdown  
                        :model-value="filters.platform"
                        @update:model-value="handleInput($event,'platform')" 
                        color="primary"
                        label="Select Platform" 
                        density="compact" 
                        variant="outlined" 
                        clearable />

            </div>
            <div class="border"></div>

            <router-link :to="'/user/vehicle-detail/'+item.id" class="link text-decoration-none" v-for="item in data" :key="item.id" >
                <div  class=" d-flex align-center w-100 item">
                    <div class="py-3 px-3 " >
                        <img :src="item.image" class="rounded border  object-fit" width="50px" height="50px" />
                    </div>
                    <div class="py-3 px-3" >
                        <div class="flex-grow-1">
                            <div class="title text-subtitle-1 font-weight-medium">
                               {{ vehicleStore.vehicle?.make?.name }} {{ vehicleStore.vehicle?.model?.name }} {{ vehicleStore.vehicle?.variant?.name }}
                            </div>
                            <div class="subtitle text-body-2 ">{{ item.platform_name }}</div>
                            <div class="subtitle text-body-2 ">{{ item.date }}</div>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </custom-card>
</template>

<script>

import PlateformDropdown from '@/components/PlateformDropdown.vue';
import Vehicle from '@/models/vehicle.model';
import { useVehicleStore } from '@/stores/vehicleStore';


export default {
    components: {
        PlateformDropdown
    },
    data() {
        return {
            vehicleStore:useVehicleStore(),
            filters: {
                platform: null,
                id: this.$route.params.id,
            },

            total: 18,
            per_page: 10,
            current_page: 1,
            last_page: 2,
            data: [],

            items: [],
            data: [],
            loading: false,
           
        };
    },
    mounted() {

        this.loadRelativeVehichle();
        // this.vehicleStore.getPlatforms({});

    },
    beforeUnmount() {

    },
    computed: {
        titleStyle() {
            return {
                color:"rgb(var(--v-theme-primary))"
            }
        }
    },
    methods: {
        handleInput(value,field){
            switch (field) {
                case 'platform':
                    this.filters.platform = value;
                    break;
            
                default:
                    break;
            }

            this.loadRelativeVehichle();
        },
        loadRelativeVehichle() {

            this.loading = true;
            Vehicle.getRelatedVehicle(this.filters).then((res) => {
                this.data = res.data;
                this.loading = false;
            }).catch(() => {
                this.loading = false;

            });

        },





    },
};
</script>

<style scoped>
::-webkit-scrollbar {
    display: none;
}

.item{
    border-bottom: 1px solid rgba(var(--v-theme-background)) ;
}

.item:hover .title{
    color: rgb(var(--v-theme-primary)); /* normal color */
    transition: color 0.2s;
}

.item:hover .subtitle{
    color: rgb(var(--v-theme-primary)); /* normal color */
    transition: color 0.2s;
}

.title {
    color: rgb(var(--v-theme-on-primary));
}

.subtitle {
    color: rgb(var(--v-theme-light));
}

</style>