<template>

    <v-card title="Account Detail" class="border" >
        <div class="border-b" ></div>

        <v-card-text>

        <v-container class="pa-2">
            
            <h2 class="text-body-1 text-light  mb-3 ">User Information</h2>
            <!-- <v-divider class="border-opacity-30 mb-4" color="grey" /> -->
            <v-row>
                <v-col cols="12" class="">
                    <div v-for="(item, i) in UserModel.fields.filter((item) => item.group == 'personal' ).filter((item) => ['firstName','phone','jobTitle','personalEmail'].includes(item.key))" :key="i" class=" d-flex align-center mb-6">
                        <v-icon color="grey-lighten-1" class="mr-4 ">{{ item.icon }}</v-icon>
                        <div class="d-flex align-center flex-wrap">
                            <div class="text-body-2  pr-2">{{ item.label }} :</div>
                            <div style="color:rgb(var(--v-theme-light))" v-if="!item.download" class="text-body-2">
                                {{userStore.user[item.key] }}
                            </div>

                        </div>
                    </div>
                </v-col>
            </v-row>

            <!-- <v-divider class="border-opacity-30 mb-4" color="grey" /> -->

            <!-- Personal Information -->
            <h2 class="text-body-1 text-light my-3 mb-3">Company Information</h2>

            <v-row>
                <v-col cols="12">
                    <div v-for="(item, i) in UserModel.fields.filter((item) => item.group == 'bussiness' )" :key="i" class="d-flex align-center mb-6">
                        <v-icon color="grey-lighten-1" class="mr-4 ">{{ item.icon }}</v-icon>
                        <div class="d-flex align-center flex-wrap">
                            <div class="text-body-1">{{ item.label }} : </div>
                            <div style="color:rgb(var(--v-theme-light))" class=" text-body-2 font-weight-medium"> {{userStore.user[item.key] }} </div>
                        </div>
                    </div>
                </v-col>
            </v-row>

            <h2 class="text-body-1 text-light mt-3  mb-3 ">Business Proof</h2>
            <v-row>
                <v-col cols="12" class="">

                    <div v-for="(item, i) in UserModel.fields.filter((item) => item.group == 'proof' )" :key="i" class=" d-flex align-center mb-6">
                        <v-icon color="grey-lighten-1" class="mr-4 ">mdi-card-account-details</v-icon>
                        <div class="d-flex align-center">
                            <div class="text-body-2 pr-2">{{ item.label }} :</div>
                            <div class="text-body-2">
                                <v-btn variant="text" size="small" target="_blank" color="primary" :href="userStore.user[item.key]"
                                    class="text-capitalize text-body-2 text-decoration-underline ">
                                    Download
                                </v-btn>
                            </div>

                        </div>
                    </div>
                </v-col>
            </v-row>

        </v-container>
          </v-card-text>
    </v-card>
</template>

<script>
import UserModel from '@/models/user.model';
import { useUserStore } from '@/stores/userStore';

export default {
    name: 'CompanyProfile',

    data() {
        return {
            userStore: useUserStore(),
            UserModel:UserModel,
        }
    },
    computed: {
        companyItems() {

            return [
                { icon: 'mdi-office-building', label: 'Business Name', value: this.userStore.user.companyName },
                { icon: 'mdi-web', label: 'Business Type', value: this.userStore.user.businessType },
                { icon: 'mdi-earth', label: 'Website', value: this.userStore.user.website },
                { icon: 'mdi-email-outline', label: 'Business Email', value: this.userStore.user.businessEmail },
                { icon: 'mdi-shield-check', label: 'Motor Trade Insurance', value: this.userStore.user.motorTradeInsurance },
                { icon: 'mdi-card-bulleted-outline', label: 'VAT Number', value: this.userStore.user.vatNumber },
                { icon: 'mdi-home-city', label: 'Company Address 1', value: this.userStore.user.companyAddress1 },
                { icon: 'mdi-home-city-outline', label: 'Company Address 2', value: this.userStore.user.companyAddress2 },
                { icon: 'mdi-map-marker', label: 'Town/City', value: this.userStore.user.townCity },
                { icon: 'mdi-flag', label: 'Country', value: this.userStore.user.country },
                { icon: 'mdi-mailbox', label: 'Postcode / Zip code', value: this.userStore.user.postcode },
                { icon: 'mdi-phone', label: 'Telephone', value: this.userStore.user.telephone }
            ];
        },
        personalItems() {

            return [
                { icon: 'mdi-account', label: 'Full Name', value: this.userStore.user.firstName + ' ' + this.userStore.user.surname },
                { icon: 'mdi-phone', label: 'Job Title', value: this.userStore.user.jobTitle },
                { icon: 'mdi-cellphone', label: 'Phone Number', value: this.userStore.user.phone },
                { icon: 'mdi-email', label: 'Email', value: this.userStore.user.personalEmail },
            ];

        }

    },

    methods: {
        downloadFile(label) {
            // Simulate file download
            alert(`Downloading ${label}...`)
            // In real app: window.location.href = '/api/download/' + label.toLowerCase().replace(/\s+/g, '-')
        }
    }
}
</script>

<style scoped></style>