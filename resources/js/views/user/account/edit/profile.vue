<template>
    <v-card :loading="loading" :disabled="loading" class="" title="Account Information" subtitle="Update User Account Information Carefully">
        <div class="border-b"></div>
        <v-card-text>
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <div class="d-flex align-center">
                            <div class="pr-2">
                                <img v-if="form?.avatar?.name" style="width:100px;height: 100px;" class="border"
                                    :src="helper.imageFileToUrl(form?.avatar)" />
                                <img v-else style="width:100px;height: 100px;" class="border" :src="form?.avatar" />
                            </div>
                            <div class="pl-3 pt-3">
                                <v-btn color="primary" @click="this.$refs.fileInput.click();" class=" text-capitalize"
                                    variant="flat">Update New Photo</v-btn>
                                <p class="pt-3 text-light text-body-2">Avatar Allowed JPG, GIF or PNG. Max size of 800K
                                </p>
                                <v-file-input ref="fileInput" clearable class="d-none" @change="hInput($event, 'avatar')"
                                    label="File input" density="comfortable" variant="filled" accept="image/*"
                                    color="primary" prepend-icon="mdi-image" />
                            </div>
                        </div>
                    </v-col>
                </v-row>
                <v-row class="mt-5">
                    <v-col cols="12" md="4">
                        <label class="form-label">Full Name</label>
                        <v-text-field :model-value="form?.firstName" @update:modelValue="hInput($event, 'firstName')" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <label class="d-block pb-2">Phone</label>
                        <v-text-field :model-value="form?.phone" @update:modelValue="hInput($event, 'phone')" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <label class="d-block pb-2">Email</label>
                        <v-text-field :model-value="form?.personalEmail"
                            @update:modelValue="hInput($event, 'personalEmail')" />
                    </v-col>
                     <v-col cols="12" md="4">
                        <label class="d-block pb-2">NIC</label>
                        <v-text-field :model-value="form?.nic"
                            @update:modelValue="hInput($event, 'nic')" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <label class="d-block pb-2">NTN</label>
                        <v-text-field :model-value="form?.ntn"
                            @update:modelValue="hInput($event, 'ntn')" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <label class="d-block pb-2">Salesman</label>
                        <v-text-field :model-value="form?.salesman"
                            @update:modelValue="hInput($event, 'salesman')" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <label class="d-block pb-2">Group</label>
                        <v-select 
                            v-model="form.group" 
                            :items="['customer','employe']"
                            />
                    </v-col>
                    <v-col cols="12" md="4">
                        <label class="form-label">Country</label>
                        <v-text-field :model-value="form?.country" @update:modelValue="hInput($event, 'country')" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <label class="form-label">City</label>
                        <v-text-field :model-value="form?.townCity" @update:modelValue="hInput($event, 'townCity')" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <label class="form-label">Street Address</label>
                        <v-text-field :model-value="form?.companyAddress1"
                            @update:modelValue="hInput($event, 'companyAddress1')" />
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
        <!-- <v-card-actions>
            <v-btn @click="onSubmit" color="primary" class=" mr-2" variant="flat">Save Changes</v-btn>
            <v-btn @click="loadDataFromProfile" color="danger" class="" variant="flat">Cancel</v-btn>
        </v-card-actions> -->
        <div class="mt-3 text-center" >
            <v-btn color="primary" @click="onSubmit">Save</v-btn>
        </div>
    </v-card>
</template>
<script>
import UserModel from '@/models/user.model';
import helper from '@/plugins/hleper';
import { toRaw } from 'vue';


export default {
    props: {
        id: {
            default: false,
        },
    },
    data() {
        return {
            loading: true,
            helper: helper,
            form: {
                id:'',
                firstName:'',
                phone:'',
                personalEmail:'',
                country:'',
                townCity:'',
                companyAddress1:'',
                salesman:'',
                nic:'',
                ntn:'',
                group:'',  
            },
            edit: false,
        };
    },
    computed: {


    },
    mounted() {
        this.loadDataFromProfile()
    },
    methods: {

        async loadDataFromProfile() {

            this.$refs.fileInput.value = null;
            this.loading = true;
            UserModel.find({ id: this.id }).then((res) => {
                
                let data = res.data.user;
                this.form = {
                        id:data?.id,
                        avatar:data?.avatar,
                        firstName:data?.firstName,
                        phone:data?.phone,
                        personalEmail:data?.personalEmail,
                        country:data?.country,
                        townCity:data?.townCity,
                        companyAddress1:data?.companyAddress1,
                        salesman:data?.salesman,
                        nic:data?.nic,
                        ntn:data?.ntn,
                        group:data?.group,
                }
                this.loading = false;

            }).catch((error) => {
                this.loading = false;
            })

        },
        hInput(value, field = null) {

            switch (field) {
                case 'avatar':

                    if (value.target.files && value.target.files.length > 0) {
                        this.form[field] = value.target.files[0];
                    } else {
                        this.form[field] = null;
                    }

                    break;
                default:
                    this.form[field] = value;
                    break;
            }

        },
        onSubmit() {


            this.loading = true;
            
            UserModel.update(this.form).then((res) => {

                this.loadDataFromProfile();
                this.loading = false;
                this.$alertStore.add('Profile Updated', 'success');

            }).catch((error) => {

                // this.loadDataFromProfile();
                this.loading = false;
                this.$alertStore.add(error.message, 'error');
            });
        }
    },

};
</script>


<style></style>