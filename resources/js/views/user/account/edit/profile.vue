<template>
    <v-card class="" title="Account Information" subtitle="All with bootstrap element classies" > 
        <div class="border-b"></div>
        <v-card-text>
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <div class="d-flex align-center">
                                    <div class="pr-2">
                                        <img v-if="helper.isFile(form?.avatar)" style="width:100px;height: 100px;" 
                                            class="border" :src="renderImage(form?.avatar)" />
                                        <img v-else style="width:100px;height: 100px;" 
                                            class="border" :src="helper.renderImage(form?.avatar)" />
                                    </div>
                                    <div class="pl-3 pt-3">
                                        <v-btn color="primary" @click="this.$refs.fileInput.click();" class=" text-capitalize" variant="flat">Update New Photo</v-btn>
                                        <p class="pt-3 text-light text-body-2">Avatar Allowed JPG, GIF or PNG. Max size of 800K</p>
                                        <v-file-input 
                                            ref="fileInput"
                                            clearable  class="d-none"
                                            @change="hInput($event,'avatar')"
                                            label="File input" 
                                            density="comfortable"
                                            variant="filled" 
                                            accept="image/*" 
                                            color="primary"
                                            prepend-icon="mdi-image"/>
                                    </div>
                                </div>
                    </v-col>
                </v-row>
                <v-row class="mt-5">
                        <v-col cols="12">
                            <h2 class="text-body-1 text-light mb-1">User Information</h2>
                        </v-col>
                        <v-col  cols="12" md="4">
                            <label class="d-block pb-2" >FullName</label>
                            <v-text-field 
                            :model-value="form?.firstName"
                            @update:modelValue="hInput($event, 'firstName')" />
                        </v-col>
                        <v-col  cols="12" md="4">
                            <label class="d-block pb-2" >Phone</label>
                            <v-text-field :model-value="form?.phone" @update:modelValue="hInput($event, 'phone')" />
                        </v-col>
                        <v-col  cols="12" md="4">
                            <label class="d-block pb-2" >Email</label>
                            <v-text-field :model-value="form?.personalEmail" @update:modelValue="hInput($event, 'personalEmail')" />
                        </v-col>
                    </v-row>
                    <v-row>
                            <v-col cols="12">
                                <h2 class="text-body-1 text-light mb-1">Address Information</h2>
                            </v-col>
                            <v-col cols="12" md="4">
                            <label class="d-block pb-2" >Country</label>
                            <v-text-field :model-value="form?.country" @update:modelValue="hInput($event, 'country')" />
                            </v-col>
                            <v-col cols="12" md="4">
                            <label class="d-block pb-2" >City</label>
                            <v-text-field :model-value="form?.townCity" @update:modelValue="hInput($event, 'townCity')" />
                            </v-col>
                            <v-col cols="12" md="4">
                            <label class="d-block pb-2" >Street Address</label>
                            <v-text-field :model-value="form?.companyAddress1" @update:modelValue="hInput($event, 'companyAddress1')" />
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-btn @click="onSubmit" class="bg-primary mr-2" variant="flat">Save Changes</v-btn>
                                <v-btn @click="loadDataFromProfile" class="bg-background" variant="flat">Cancel</v-btn>
                            </v-col>
                        </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
        
        </v-card-actions>
    </v-card>
</template>
<script>
import UserModel from '@/models/user.model';
import helper  from '@/plugins/hleper';
import { toRaw } from 'vue';


export default {
    props:{
        id: {
            default: false,
        },
    },
    data() {
        return {
            loading:false,
            helper:helper,
            form:{},
            edit:false,
        };
    },
    computed: {
   
        
    },
    mounted(){
      this.loadDataFromProfile()
    },
    methods: {

    async loadDataFromProfile() {

            // this.$refs.fileInput.value = null;
            this.loading = true;
            UserModel.find({id:1}).then((res) => {
                let data = res.data.user;
                this.form = data;
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
        console.log(toRaw(this.form));
        
        // authService.updateProfile(this.form).then((res) => {
        //     console.log(res);
        //     this.loadDataFromProfile();
        //     this.loading = false;
        //     this.$alertStore.add('Profile Updated', 'success');

        // }).catch((error) => {

        //     this.loadDataFromProfile();
        //     this.loading = false;
        //     this.$alertStore.add(error.message, 'error');
        // });

    }


  },

};
</script>


<style>

  
</style>