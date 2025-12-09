<template>
    <v-app>
        <div class="position-absolute bottom-0 left-0 right-0 h-50 bg-primary"
            style="z-index: 0; clip-path: polygon(0 29%, 100% 0, 100% 100%, 0% 100%);">
        </div>
        <AuthHeader />

        <v-main style="z-index: 10;" class="z-index-1 h-lg-screen d-flex align-center justify-center">
            <v-container fluid class="d-flex justify-center align-center">
                <v-row justify="center">
                    <v-col cols="12" sm="10" md="8" lg="6" xl="5">
                        <v-stepper class="pa-4" v-model="step"
                            :items="['Company Info', 'User Info', 'Proof', 'Security']" color="primary">

                            <!-- Step 1 -->
                            <template v-slot:item.1>
                                <v-card flat>
                                    <v-card-title class="text-h4 font-weight-bold mb-n2">Company
                                        Information</v-card-title>
                                    <v-card-subtitle class="text-medium-emphasis">
                                        Provide your company details.
                                    </v-card-subtitle>
                                    <v-container fluid class="py-6">
                                        <v-row class="gap-4" justify="start">
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                   persistent-placeholder 
                                                   v-model="form.companyName" 
                                                   :error-messages="errors?.companyName"
                                                   variant="outlined" 
                                                   density="comfortable" 
                                                   label="Company / Business Name"
                                                   placeholder="Company / Business Name" 
                                                   color="primary" 
                                                   clearable required />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    persistent-placeholder
                                                    v-model="form.companyAddress1"
                                                    :error-messages="errors?.companyAddress1" 
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="Company Address"
                                                    placeholder="Company Address" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    persistent-placeholder
                                                    v-model="form.companyAddress2"
                                                    :error-messages="errors?.companyAddress2" 
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="Company Address 2" 
                                                    placeholder="Company Address 2"
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-select
                                                    persistent-placeholder
                                                    v-model="form.businessType"
                                                    :error-messages="errors?.businessType" 
                                                    density="comfortable" 
                                                    variant="outlined" 
                                                    label="Business Type"
                                                    placeholder="Business Type"
                                                    :items="['Motor Dealer', 'Motor Trader', 'Independent Dealer', 'Other']"
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    persistent-placeholder 
                                                    v-model="form.companyReg"
                                                    :error-messages="errors?.companyReg"
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="Company Reg. Number"
                                                    placeholder="Company Reg. Number" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    persistent-placeholder
                                                    v-model="form.townCity"
                                                    :error-messages="errors?.townCity" 
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="Town / City"
                                                    placeholder="Town / City" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field 
                                                    persistent-placeholder
                                                    v-model="form.website"
                                                    :error-messages="errors?.website" 
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="Website (Optional)"
                                                    placeholder="Website (Optional)" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="form.country"
                                                    :error-messages="errors?.country" 
                                                    variant="outlined" 
                                                    density="comfortable" 
                                                    label="Country"
                                                    color="primary"
                                                    placeholder="Country" 
                                                    persistent-placeholder
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field 
                                                    v-model="form.businessEmail"
                                                    :error-messages="errors?.businessEmail"
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="Business Email (optional)"
                                                    placeholder="Business Email (optional)" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    persistent-placeholder
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="Postal Code / Zip Code"
                                                    placeholder="Postal Code / Zip Code" 
                                                    v-model="form.postcode"
                                                    :error-messages="errors?.postcode"
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-select
                                                    persistent-placeholder 
                                                    density="comfortable" 
                                                    variant="outlined"
                                                    v-model="form.motorTradeInsurance"
                                                    :error-messages="errors?.motorTradeInsurance"
                                                    label="Motor Trade Insurance"
                                                    placeholder="Motor Trade Insurance" 
                                                    :items="['Yes', 'No', 'Pending']"
                                                    color="primary" 
                                                    clearable="" />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    label="Cell"
                                                    placeholder="Cell"
                                                    persistent-placeholder 
                                                    variant="outlined" 
                                                    v-model="form.telephone"
                                                    :error-messages="errors?.telephone"
                                                    density="comfortable" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field 
                                                    variant="outlined"
                                                    placeholder="VAT Number (optional)"
                                                    persistent-placeholder 
                                                    v-model="form.vatNumber"
                                                    :error-messages="errors?.vatNumber"
                                                    density="comfortable"
                                                    label="VAT Number (optional)" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card>
                            </template>

                            <!-- Step 2 -->
                            <template v-slot:item.2>
                                <v-card flat>
                                    <v-card-title class="text-h4 font-weight-bold mb-n2">User Information</v-card-title>
                                    <v-card-subtitle class="text-medium-emphasis">
                                        Add your personal details and profile image.
                                    </v-card-subtitle>
                                    <v-container fluid class="py-6">
                                        <v-row class="gap-4" justify="start">
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="form.firstName" 
                                                    :error-messages="errors?.firstName" 
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="First Name" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="form.surname"
                                                    :error-messages="errors?.surname" 
                                                    variant="outlined" 
                                                    density="comfortable" 
                                                    label="Surname"
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-select
                                                    v-model="form.source"
                                                    :error-messages="errors?.source"
                                                    density="comfortable" 
                                                    variant="outlined"
                                                    label="Referral Source?"
                                                    :items="source"
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field 
                                                    variant="outlined"
                                                    v-model="form.phone"
                                                    :error-messages="errors?.phone"
                                                    density="comfortable"
                                                    label="Phone Number" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field 
                                                    variant="outlined" 
                                                    density="comfortable" 
                                                    label="Position"
                                                    color="primary" 
                                                    :error-messages="errors?.jobTitle"
                                                    v-model="form.jobTitle"
                                                    clearable />
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-card-subtitle class="ml-n3 mb-2 text-medium-emphasis">Profile Image</v-card-subtitle>
                                                <v-file-input clearable 
                                                    label="File input"
                                                    v-model="form.avatar"
                                                    :error-messages="errors?.avatar" 
                                                    density="comfortable"
                                                    variant="outlined" 
                                                    accept="image/*" 
                                                    color="primary"
                                                    prepend-icon="mdi-image" />
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card>
                            </template>

                            <!-- Step 3 -->
                            <template v-slot:item.3>
                                <v-card flat>
                                    <v-card-title class="text-h4 font-weight-bold mb-n2">Proof Documents</v-card-title>
                                    <v-card-subtitle class="text-medium-emphasis">
                                        Upload required proof documents.
                                    </v-card-subtitle>
                                    <v-row class="gap-4 mt-6" justify="start">
                                        <v-col cols="12" sm="6">
                                            <div class="text-medium-emphasis text-caption mb-2">Proof of motor trade
                                            </div>
                                            <v-file-input 
                                                clearable
                                                v-model="form.motorTradeProof"
                                                :error-messages="errors?.motorTradeProof"  
                                                label="File input" 
                                                density="comfortable"
                                                variant="outlined" 
                                                accept="image/*" 
                                                color="primary"
                                                prepend-icon="mdi-image"/>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <div class="text-medium-emphasis text-caption mb-2">Proof of address</div>
                                            <v-file-input 
                                                clearable 
                                                v-model="form.addressProof"
                                                :error-messages="errors?.addressProof" 
                                                label="File input" 
                                                density="comfortable"
                                                variant="outlined" 
                                                accept="image/*" 
                                                color="primary"
                                                prepend-icon="mdi-image"/>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </template>

                            <!-- Step 4 -->
                            <template v-slot:item.4>
                                <v-card flat>
                                    <v-card-title class="text-h4 font-weight-bold mb-n2">Security</v-card-title>
                                    <v-card-subtitle class="text-medium-emphasis">
                                        Set your login email & password.
                                    </v-card-subtitle>
                                    <v-container fluid class="py-6">
                                        <v-row class="gap-4" justify="start">
                                            <v-col cols="12" sm="6">
                                                <v-text-field
                                                    v-model="form.personalEmail"
                                                    :error-messages="errors?.personalEmail" 
                                                    variant="outlined" 
                                                    density="comfortable"
                                                    label="Personal / Login Email" 
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                            <v-col cols="12" sm="6">
                                                <v-text-field 
                                                    v-model="form.password"
                                                    :error-messages="errors?.password"
                                                    variant="outlined" 
                                                    density="comfortable" 
                                                    label="Password"
                                                    color="primary" 
                                                    clearable />
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card>
                            </template>

                            <!-- Footer Actions with Login Message -->
                            <template v-slot:actions="{ next, prev }">
                                <v-row class="w-100 align-center px-4 py-2 border-t" no-gutters>
                                    <!-- Login message only on last step -->
                                    <v-col cols="12" sm="4"
                                        class="d-flex align-center justify-center justify-sm-start mb-2 mb-sm-0">
                                        <div class="text-medium-emphasis text-center text-sm-left">
                                            Already have an account?
                                            <v-btn to="/login" variant="plain" class="px-1 text-body-2" color="primary"
                                                size="small">
                                                Login
                                            </v-btn>
                                        </div>
                                    </v-col>

                                    <!-- Previous & Next/Submit Buttons -->
                                    <v-col cols="12" sm="8" class="d-flex justify-center justify-sm-end">
                                        <v-btn class="mr-2" variant="tonal" color="primary" :disabled="step === 1"
                                            @click="prev">
                                            <v-icon start>mdi-arrow-left</v-icon>
                                            Previous
                                        </v-btn>

                                        <v-btn variant="flat" color="primary" @click="handleNext(next)">
                                            {{ step === 4 ? 'Submit' : 'Next' }}
                                            <v-icon end>{{ step === 4 ? 'mdi-check' : 'mdi-arrow-right' }}</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </template>

                        </v-stepper>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>

        <!-- Optional Snackbar for Submit -->
        <v-snackbar v-model="showMessage" color="success" timeout="2500">
            Form submitted successfully!
        </v-snackbar>
    </v-app>
</template>
<script>
import { useThemeStore } from '@/stores/themeStore';
import AuthHeader from './AuthHeader.vue';
import { useUserStore } from '@/stores/userStore';
import { useAlertStore } from '@/stores/alertStore';


export default {
    name: "StepperForm",
    components: { AuthHeader },
    data() {
        return {
            themeStore: useThemeStore(),
            userStore: useUserStore(),
            alertStore: useAlertStore(),
            form: {
                companyName: 'Business 1',
                companyAddress1: 'Address 1',
                companyAddress2: 'Address 2',
                businessType:'Other',
                companyReg:'1234',
                townCity:'Karachi',
                website:'https://localhost/autoboli/register',
                country:'Pakistan',
                businessEmail:'business35@gmail.com',
                postcode: '1234',
                motorTradeInsurance:'yes',
                telephone: '03112239342',
                vatNumber: '12345',

                firstName: 'Owais',
                surname: 'Azam',
                source: 'Other',
                phone: '03112239342',
                jobTitle: 'Test Title',
                avatar:null,
        
                motorTradeProof:null,
                addressProof:null,

                personalEmail:'iamowaisazam35@gmail.com',
                password:'owais123',
                
            },
            errors: {
                
            },
            source: [
                'Google Search',
                'Social Media',
                'Online Advertisement',
                'Friend / Colleague',
                'Dealership Partner',
                'Trade Event or Expo',
                'Vehicle Trader Forum',
                'Other'
            ],
            step: 1,
            proofMotorTrade: [],
            proofAddress: [],
            showMessage: false,
        };
    },
    mounted() {

        this.$themeStore.startLoading()
        this.userStore.getProfile().then(() => {
            this.$themeStore.endLoading()
            this.$router.replace("/user/dashboard");
        }).catch(() => this.$themeStore.endLoading())
        
    },
    methods: {
        handleNext(next) {
            switch (this.step) {
                case 1:
                    this.step1(next);       
                    break;
                case 2:
                    this.step2(next);       
                    break;
                case 3:
                    this.step3(next);       
                    break;
                case 4:
                    this.step4(next);       
                    break;
                default:
                    
                break;
            }
        },
        step1(next) {

            next()
        },
        step2(next) {
            next()
        },
        step3(next) {
            next()
        },
        step4(next) {
            this.onSubmit();
        },
        async onSubmit() {            

            this.themeStore.startLoading()
            this.errors = {};

            try {

                console.log(this.form);
                
                let response = await this.userStore.registerRequest(this.form);
                this.userStore.initializeUserSession(response.token,response.user);
                this.themeStore.endLoading();
                this.alertStore.add('Account Created Successfully','success');
                    
            } catch (error) {

                this.themeStore.endLoading();
                this.errors = error.validation || {};
                this.alertStore.add(error.message, 'error');

            }


        }

    },
};
</script>

