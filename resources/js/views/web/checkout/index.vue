<template>
    <v-container fluid max-width="1300px" class="bg-background pa-8">
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4 text-white mb-6 text-center">Checkout</h1>
            </v-col>
            <v-col cols="12" lg="7">

                <v-card class="pa-6" elevation="4" :loading="loading" >
                    <v-card-title class="text-h6 text-white mb-4">Billing Info</v-card-title>
                    <div class="border"></div>

                    <v-card-text class="pa-0">
                        <div class="pt-5 pb-10">
                            <span style="padding-right: 13px;padding-bottom: 10px;border-bottom: 3px solid #0080ff;"
                                class=" text-subtitle-1 text-white ">User Details</span>
                        </div>
       
                        <v-row>
                            <v-col cols="12" sm="6">
                                <v-text-field 
                                    v-model="form.first_name" 
                                    label="First Name" 
                                    variant="outlined"
                                    density="comfortable"
                                     />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field 
                                    v-model="form.last_name" 
                                    label="Last Name" 
                                    variant="outlined"
                                    density="comfortable"
                                     />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field 
                                    v-model="form.phone" 
                                    label="Phone" 
                                    variant="outlined"
                                    density="comfortable"  
                                     />
                            </v-col>
                             <v-col cols="12" sm="6">
                                <v-text-field 
                                    v-model="form.email" 
                                    label="Email" 
                                    variant="outlined"
                                    density="comfortable"  
                                     />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field 
                                    v-model="form.country" 
                                    label="Country" 
                                    variant="outlined"
                                    density="comfortable" 
                                     />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field 
                                    v-model="form.state" 
                                    label="State" 
                                    variant="outlined" 
                                    density="comfortable" 
                                     />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field 
                                    v-model="form.city" 
                                    label="City" 
                                    variant="outlined" 
                                    density="comfortable" 
                                     />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field 
                                    v-model="form.zip_code" 
                                    label="Zip Code" 
                                    variant="outlined"
                                    density="comfortable" 
                                     />
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field 
                                    v-model="form.address" 
                                    label="Address" 
                                    variant="outlined" 
                                    density="comfortable"
                                     />
                            </v-col>
                        </v-row>

                        <div>
                            <div class="pt-5 pb-8">
                                <span style="padding-right: 13px;padding-bottom: 10px;border-bottom: 3px solid #0080ff;"
                                    class=" text-subtitle-1 text-white ">Card Details</span>
                            </div>
                            <div>
                                <v-text-field
                                    v-model="form.cardholderName"
                                    label="Name on card"
                                    variant="outlined"
                                    density="comfortable"
                                    />
                            </div>
                            <div class="pt-3" >
                                <div id="card-element" class="my-4"></div>
                                <div id="card-errors" class="text-red text-caption"></div>
                            </div>
                                    
                        </div>
                            
                        <v-btn color="primary" class="mt-8 text-white text-capitalize" @click="submit">Submit</v-btn>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="5">
                <v-card class="pa-6 bg-surface" elevation="4" height="100%" :loading="loading" >

                    <v-card-title class="text-h6 text-white mb-4">Order Summary</v-card-title>
                    <div class="border"></div>
                    <!-- <div class="pt-5 mb-6">
                        <div class="d-flex justify-space-between align-center mb-3">
                            <span class="text-white">Your Plan</span>
                            <v-chip color="blue-lighten-1" label class="px-4">
                                <v-icon start>mdi-check</v-icon>
                                Free
                            </v-chip>
                        </div>
                    </div> -->

                    <div>
                        <div v-for="item in planList" :key="item.id">
                            <div v-if="item.id == selectedPlan">
                                <div class="text-caption text-grey-lighten-1">
                                    {{ item.short_desc }}
                                </div>
                                <div class="text-h4 text-white font-weight-bold mt-2">
                                    £{{ item.price }}
                                    <span class="text-caption text-grey-lighten-1">Per {{ item.duration_unit }}</span>
                                </div>
                            </div>
                        </div>

                        <v-select v-model="selectedPlan" :items="planList" item-title="title" item-value="id"
                            label="Select Plan" variant="outlined" density="comfortable" class="mt-6" clearable="" />
                    </div>

                    <v-divider class="my-6"></v-divider>

                    <div class="text-white">
                        <div class="d-flex justify-space-between mb-2">
                            <span>Base price</span>
                            <span>£{{ currentPlan?.price }}</span>
                        </div>
                        <div class="d-flex justify-space-between mb-2">
                            <span>Discount</span>
                            <span>£0.00</span>
                        </div>
                        <div class="d-flex justify-space-between mb-4">
                            <span>GST</span>
                            <span>£0.00</span>
                        </div>

                        <v-divider></v-divider>

                        <div class="d-flex justify-space-between mt-4 text-h6">
                            <strong>Total</strong>
                            <strong>£{{ currentPlan?.price }}</strong>
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>

    </v-container>
</template>

<script>
import api from '@/plugins/axios';
import { useUserStore } from '@/stores/userStore';
import { loadStripe } from "@stripe/stripe-js";




export default {
    name: 'CheckoutPage',
    data() {
        return {
            userStore: useUserStore(),
            stripe: null,
            cardElement: null,
            processing: false,
            loading:false,
            form: {
                first_name: '',
                last_name:'', 
                email: '',
                phone: '',
                country: '',
                state:'',
                city: '',
                zip_code: '',
                address: '',

                payment_method_id: '',
                plan_id: null,
                cardholderName:'',
            },
            selectedPlan: null,
            planList: [],
        }
    },
    async mounted() {
    
       this.getPlans();
       this.getAuth();
       this.stripeLoad();
             
    },
    computed: {
        oldPlan() {
            return this.userStore.user?.plans;  
        },
        currentPlan() {
            return this.planList.find((item) => item.id == this.selectedPlan)
        }
    },
    methods: {
       async stripeLoad() { 

            this.stripe = await loadStripe("pk_test_TYooMQauvdEDq54NiTphI7jx");
            const elements = this.stripe.elements();
            this.cardElement = elements.create('card', {
                style: {
                    base:{
                        color: '#fff',
                        fontSize: '16px',
                        '::placeholder': { color: '#aab7c4' },
                    }
                }
            });
            this.cardElement.mount('#card-element');
        
        },
        getPlans() {
            try {
                api.get('/api/user/page/plansList').then((res) => {
                    this.planList = res.data.data;
                }).catch((error) => {
                    alert()
                });

            } catch (error) {
                alert('Something Went Wrong Contact To Admin.');
            }
        },
        getAuth() { 

            this.form.first_name = this.userStore.user?.firstName;
            this.form.last_name = this.userStore.user?.firstName;
            this.form.phone = this.userStore.user?.phone;
            this.form.email = this.userStore.user?.personalEmail;
            this.form.country = this.userStore.user?.country;
            this.form.state = this.userStore.user?.townCity; 
            this.form.city = this.userStore.user?.townCity;
            this.form.zip_code = this.userStore.user?.postcode;
            this.form.address = this.userStore.user?.companyAddress1;
            this.form.cardholderName = this.userStore.user?.firstName;

        },
        async submit() {

            console.log(this.selectedPlan);
            
            this.loading = true;
                
            try {

            
                if(!this.selectedPlan) {
                    this.$alertStore.add("Please Select Plan", "error");
                    return false;
                }

                if (!this.form.cardholderName) {
                    this.$alertStore.add("Please Add Cardholder Name", "error");
                    return false;
                }
                
                this.processing = true;

                const { paymentMethod, error } = await this.stripe.createPaymentMethod({
                    type: 'card',
                    card: this.cardElement,       
                    billing_details: { name: this.form.cardholderName },
                });

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    this.processing = false;
                    return;
                }

                this.form.payment_method_id = paymentMethod.id;
                this.form.plan_id = this.selectedPlan;
                const res = await api.post('/api/stripe/createPaymentIntent', this.form);
                this.$alertStore.add("Form Submitted", "success");
                this.processing = false;
                
                this.loading = false;
                this.getAuth();

            } catch (error) {
           
                this.loading = false;
             
                this.$alertStore.add(error.message,"error")
             
            }

        }


    },

}
</script>

<style scoped>
.text-h6,
.text-h4,
.text-white {
    font-family: 'Inter', sans-serif !important;
}
</style>