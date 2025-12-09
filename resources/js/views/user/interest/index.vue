<template>
    <main>

        <user-title-bar title="Personalized for You"
            subtitle="Save your interests to see matching auctions, stats, and valuations in one place.">
            <v-btn append-icon="mdi-plus" color="primary" variant="flat" to="/create"> Create Interest</v-btn>
        </user-title-bar>

    
        <createFrom />
        <div class="pa-1 pa-sm-3 pt-6">
            <div class="mainContent mr-auto ml-auto">
                <div
                    class="d-flex flex-wrap align-start align-sm-center justify-space-between flex-column flex-sm-row ga-5">
                    <div class="leftElements d-flex align-center ga-3">
                        <v-select label=""
                           v-model="itemsPerPage" 
                          :items="['10', '20', '50', '100', '500', '1000']" 
                          variant="outlined" 
                          color="primary" 
                          width="140" 
                          density="compact" 
                          clearable></v-select>
                    </div>
                    <div class="rightElements d-flex flex-wrap align-center ga-3">
                        <v-btn prepend-icon="mdi-reload"  variant="flat" @click="loadItems"></v-btn>
                        <v-text-field label="Search..." 
                            v-model="search" 
                            prepend-inner-icon="mdi-magnify" 
                            density="compact" 
                            width="200"
                            variant="outlined" 
                            color="primary" 
                            clearable />
                    </div>
                </div>

                 <v-data-table-server 
                   class="dataTable" 
                   :headers="headers" 
                   :items="items"
                   :items-length="totalItems" 
                   :loading="loading" 
                   item-value="id" 
                   @update:options="loadItems"
                   ></v-data-table-server>

            </div>
        </div>
    </main>
</template>

<script>

import { useInterestStore } from '@/stores/interestStore';
import { useAlertStore } from '@/stores/alertStore';
import createFrom from "./create.vue"



export default {
    props: {},
    components: {
        createFrom
    },
    data() {

        return {
            interestStore: useInterestStore(),
            alertStore:useAlertStore(),
            search:'',
            loading:true,
            totalItems:0,
            itemsPerPage:10,
            headers:[
                {
                    title: 'name',
                    key: 'name',
                },
                {
                    title: 'Make',
                    key: 'make_title',
                },
                {
                    title: 'Model',
                    key: 'model_title',
                },
                {
                    title: 'Vairant',
                    key: 'variant_title',
            
                },
                {
                    title: 'Year',
                    key: 'year',
                },
                {
                    title: 'Mileage	',
                    key: 'mileage',
                },
                {
                    title: 'CC',
                    key: 'cc',
                },

                	
            ],
            items: [
            ],
            
        }

    },
    methods: {
       async loadItems({ page, itemsPerPage, sortBy }) {
            
            try {

                this.alertStore.add("Record Get Success",'success');
                let response = await this.interestStore.getMyInterest({
                    length: itemsPerPage,
                    search:this.search
                })
                this.items = response.data;
                this.totalItems = response.recordsTotal;
                this.loading = false;

                
            } catch (error) {


                this.alertStore.add(error, 'error');
                
            }
                  
                // loading.value = true;
                // FakeAPI.fetch({ page, itemsPerPage, sortBy }).then(({ items, total }) => {
                //     serverItems.value = items;
                //     totalItems.value = total;
                //     loading.value = false;
                // });
        }
    }

};
</script>

<style scoped>

</style>
