<template>
    <custom-card title="Recent Devices" class="">
        <v-data-table-server class="pb-3" 
            :headers="pageStore.recentDevices.headers" 
            :items="pageStore.recentDevices.data" 
            :items-length="pageStore.recentDevices.total"
            :loading="pageStore.recentDevices.loading" 
            item-value="id"
            >
                <template #item.platform="{ item }">
                    <p>
                        <v-icon class="text-primary" icon="mdi-microsoft-windows-classic" /> 
                        <span class="px-2 font-weight-thin" > {{ item.platform }}</span>
                    </p>
                </template>
                <template #item.browser="{ item }">
                    <p>
                        <v-icon class="text-orange" icon="mdi-google-chrome" /> 
                        <span class="px-2 font-weight-thin" > {{ item.browser }}</span>
                    </p>
                </template>

                <template v-slot:bottom>
                    <div class="py-2" >
                        <custom-pagination
                        :loading="pageStore.recentDevices.loading"
                        v-model:page="pageStore.recentDevices.page" 
                        :lastPage="pageStore.recentDevices.last_page"
                        />
                    </div>
                </template>
            </v-data-table-server>
    </custom-card>


</template>
<script>
 import { useUserStore } from '@/stores/userStore';
 import { usePageStore } from '@/stores/pageStore';

 export default {
    components: {

    },
    data() {
        return {
            pageStore: usePageStore(),
            

        };
    },
    computed: {

    },
    mounted() {

       
    },
    methods: {
     
    }
};
</script>
