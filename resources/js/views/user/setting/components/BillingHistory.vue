<template>
    <v-card title="Billing History" class="">
            <div class="border" ></div>
            <v-data-table-server class="pb-3" 
                :headers="headers" 
                :items="data" 
                :items-length="data.length" 
                item-value="id"
                >
                    <template #item.status="{ item }">
                        <v-btn v-if="item.status == 'Active'"   class="text-capitalize">{{ item.status }}</v-btn>
                        <v-btn v-else-if="item.status == 'Expired'"  class="text-capitalize">{{ item.status }}</v-btn>
                        <v-btn v-else  class="text-capitalize">{{ item.status }}</v-btn>
                    </template>

                    <template #item.invoice="{ item }">
                        <v-btn icon="mdi-eye" ></v-btn>
                        <v-btn icon="mdi-download"></v-btn>
                    </template>
            </v-data-table-server>
        </v-card>
</template>

<script>

 import { usePageStore } from '@/stores/pageStore';
import { useUserStore } from '@/stores/userStore';

 export default {
    components: {

    },
    data() {
        return {
            pageStore: usePageStore(),
            userStore: useUserStore(),
            data: [],
            headers: [
                { title: "Id", key: "id" },
                { title: "Date", value: "updated_at" },
                { title: "Plan Name", value: "plan.plan_name" },
                { title: "Start", value: "membership_start_date" },
                { title: "Expiry", value: "membership_expiry_date" },
                { title: "Amount", value: "plan.price" },
                { title: "Status", value: "membership_status" },
                { title: "Invoice", value: "invoice" },
            ],
        };
    },
    computed: {

    },
    mounted() {
        
        
        // this.loadDataFromProfile();
        this.data = this.userStore.user.billingHistory

    },
    methods: {
        loadDataFromProfile() {
          
        }
    }
};
</script>
