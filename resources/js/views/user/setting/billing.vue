<template>
    <v-col cols="12" v-if="userStore?.user?.plans" >
        <CurrentPlan  />
   
        <!-- <PaymentForm/> -->
    </v-col>

    <!-- <v-col cols="12">
        <pricePlan/>
    </v-col> -->

      <v-col cols="12" >
        <BillingHistory/>
    </v-col>
</template>

<script>
import CurrentPlan from './components/currentPlan.vue';
// import pricePlan from './components/pricePlan.vue';
// import PaymentForm from './components/PaymentForm.vue';
import BillingHistory from './components/BillingHistory.vue';
import { useUserStore } from '@/stores/userStore';


export default {
    components: {
     CurrentPlan,
    //  pricePlan,
    //  PaymentForm,
     BillingHistory
    },
    data() {
        return {
            userStore:useUserStore
        };
    },
    computed: {
        
    },
};
</script>