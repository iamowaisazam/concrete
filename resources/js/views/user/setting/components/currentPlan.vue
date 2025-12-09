<template>
    <v-card title="Current Plan" class="bg-surface"  >
        <div class="border" ></div>
        <v-container>
            <div class="d-flex  flex-wrap justify-space-between">

                <div class="py-3 px-3">

                    <div class="d-flex align-center  rounded-lg px-5 mb-3 py-1" style="background-color: #504448;" >
                        <p class="px-1 py-1 rounded bg-warning">
                            <v-icon color="white" icon="mdi-alert" />
                        </p>
                        <div class="pl-3 py-3">
                            <h6 class="text-h5 text-warning font-weight-bold ">We need your attention!</h6>
                            <p class="text-body-2 text-warning">Your plan requires update</p>
                        </div>
                    </div>

                    <div class="w-100">
                        <p class="d-flex justify-space-between">
                            <span class="text-body-1">Days</span>
                            <span class="text-body-1">{{ usedDays }} of 30 Days</span>
                        </p>
                        <div class="py-3" style="width:300px">
                            <v-progress-linear height="7" color="warning" :model-value="progressPercentage"></v-progress-linear>
                        </div>
                        <p class="text-body-2" style="color:rgb(var(--v-theme-light))">{{ remainingDays }} days remaining until your plan
                            requires update</p>
                    </div>

                    <div class="py-5">
                        <div class="mb-3">
                            <p class="text-body-1">Your Current Plan is "{{ userStore.user.plans.plan.plan_name }}"</p>
                            <p class="text-body-2" style="color:rgb(var(--v-theme-light))">For small dealers.</p>
                        </div>
                        <div>
                            <p class="text-body-1">Active until {{ userStore.user.plans.membership_expiry_date }} </p>
                            <p class="text-body-2 font-weight-thin" style="color:rgb(var(--v-theme-light))">We will send you a notification upon Subscription expiration</p>
                        </div>
                    </div>

                    <div>
                        <v-btn 
                            @click="showDialog = true" 
                            color="primary" 
                            text="Price Plain" 
                            variant="flat"
                            class="text-capitalize"
                            />

                        <v-btn 
                            class="mx-2 text-capitalize" 
                            @click="showDialog = true"
                            color="danger" 
                            text="Cancle Subscription"
                            variant="flat" />
                    </div>
                    
                    <v-container class="d-flex m-2">
                        <v-dialog v-model="showDialog" max-width="">
                            <template v-slot:default="{ isActive }">
                                <v-btn icon="mdi-close" variant="flat" @click="isActive.value = false"
                                    style="position: absolute; z-index: 1; right: 0;"></v-btn>
                                <PricePlan />
                            </template>
                        </v-dialog>
                    </v-container>
                </div>
                <PaymentForm />
            </div>
        </v-container>
    </v-card>
</template>
<script>

import { useUserStore } from '@/stores/userStore';
import { usePageStore } from '@/stores/pageStore';
import PaymentForm from './PaymentForm.vue';
import PricePlan from './pricePlan.vue';

export default {
    components: {
        PaymentForm,
        PricePlan
    },
    data() {
        return {
            userStore: useUserStore(),
            pageStore: usePageStore(),
            showDialog: false,
            totalDays:30,
        };
    },
    computed: {
        remainingDays() {
         
            const today = new Date();

            const expiry = new Date(this.userStore.user.plans?.membership_expiry_date);

            // const expiry = new Date(this.userStore.user.plans.membership_expiry_date);

            
            const diffTime = expiry - today;
            return diffTime > 0 ? Math.ceil(diffTime / (1000 * 60 * 60 * 24)) : 0;
        },
        usedDays() {
           return this.totalDays - this.remainingDays;
        },
        progressPercentage() {
            return (this.usedDays / this.totalDays) * 100;
        }
    },
    mounted() {


    },
    methods: {
        loadDataFromProfile() {

        }
    }
};
</script>
