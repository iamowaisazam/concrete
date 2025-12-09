<template>
    <v-col cols="12">
        <v-card :loading="loading" :disabled="loading" class="border" title="Personal Information">
            <div class="border-b"></div>
            <v-card-text>
                <v-container fluid>
                    <v-row>
                        <v-col cols="12">
                            <div class="d-flex align-center">
                                <div class="pr-2">
                                    <img v-if="isFile(form['avatar'])" style="width:100px;height: 100px;" 
                                         class="border" :src="image" />
                                    <img v-else style="width:100px;height: 100px;" 
                                         class="border" :src="image" />
                                </div>
                                <div class="pl-3 pt-3">
                                    <v-btn color="primary" @click="this.$refs.fileInput.click();" class=" text-capitalize" variant="flat">Update New Photo</v-btn>
                                    <p class="pt-3 text-light text-body-2">{{ UserModel.getField('avatar')?.placeholder }}</p>
                                     <v-file-input 
                                        ref="fileInput"
                                        clearable  class="d-none"
                                        @change="onFileChange($event,'avatar')"
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
                        <v-col v-for="(value, key) in UserModel.groupByFields('personal').filter((res) => res.key != 'avatar')" cols="12" md="4">
                            <label class="d-block pb-2" :for="value.label">{{ value.label }}</label>
                            <v-text-field   
                                v-model="form[value.key]" 
                                variant="outlined" 
                                color="primary"
                                density="compact" 
                                clearable />

                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <h2 class="text-body-1 text-light mb-1">Company Information</h2>
                        </v-col>
                        <v-col v-for="(value, key) in UserModel.fields.filter((res) => res.group == 'bussiness')" cols="12" md="4">
                            <label class="d-block pb-2" :for="value.label">{{ value.label }}</label>
                            <v-select v-if="value.type == 'select'" 
                                v-model="form[value.key]" 
                                variant="outlined" 
                                color="primary"
                                :items="['yes','no']"
                                density="compact" />

                            <v-text-field v-else
                            v-model="form[value.key]" 
                            variant="outlined" 
                            color="primary"
                            density="compact" 
                            clearable />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <h2 class="text-body-1 text-light mb-1">Proof Information</h2>
                        </v-col>
                        <v-col v-for="(value, key) in UserModel.groupByFields('proof')" cols="12" md="4">
                             <label class="d-block pb-2" :for="value.label">{{ value.label }}</label>
                             <v-file-input 
                                clearable 
                                @change="onFileChange($event, value.key)"
                                label="File input" 
                                density="comfortable"
                                variant="outlined" 
                                accept="image/*" 
                                color="primary"
                                prepend-icon="mdi-image"/>
                                
                              <div v-if="form[value.key]" class="text-body-2 mb-2">
                                    <div v-if="isFile(form[value.key])" > 
                                         Current File: <a  target="_blank">{{ form[value.key].name }}</a> 
                                    </div>
                                    <div v-else> 
                                        Current File: <a :href="form[value.key]" target="_blank">{{ form[value.key].split('__ff__')[1] }}</a> 
                                    </div>
                              </div>
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
        </v-card>
    </v-col>
</template>

<script>
import UserModel from '@/models/user.model';
import authService from '@/services/authService';
import { useUserStore } from '@/stores/userStore';
import { toRaw } from 'vue';


export default {
    components: {

    },
    data() {
        return {
            userStore: useUserStore(),
            UserModel: UserModel,
            loading: false,
            files: {
            },
            form: {}
        };
    },
    computed: {
        image() {
            
            if (this.form.avatar instanceof File ) {
                return URL.createObjectURL(this.form.avatar);
            } else {
                return this.form.avatar;
            }

        }
    },
    mounted() {

        UserModel.fields.map(res => (this.form[res.key] = ''));

        console.log(toRaw(this.form));
        this.loadDataFromProfile();

    },
    methods: {
        isFile(value) {
          return value instanceof File;
        },
        onFileChange(file, key) {

            if (file.target.files && file.target.files.length > 0) {
                this.form[key] = file.target.files[0];
            } else {
                this.form[key] = null;    
            }

        },
        async loadDataFromProfile() {

            UserModel.fields.map(res => (this.form[res.key] = ''));
            this.$refs.fileInput.value = null;
            this.loading = true;

            authService.getProfile().then((res) => {
                let data = res.data.user
                for (const key in this.form) {
                    if (!Object.hasOwn(this.form, key)) continue;
                    const value = this.form[key];
                    // if (['uploadID', 'motorTradeProof', 'addressProof'].includes(key)) {
                    //     continue;
                    // }
                    if (Object.hasOwn(data, key)) {
                        this.form[key] = data[key];
                    } else {
                        this.form[key] = ''
                    }
                }
                this.loading = false;
            }).catch((error) => {
                this.loading = false;
            })

        },
        onSubmit() {

            this.loading = true;
            authService.updateProfile(this.form).then((res) => {
                console.log(res);
                this.loadDataFromProfile();
                this.loading = false;
                this.$alertStore.add('Profile Updated', 'success');

            }).catch((error) => {

                this.loadDataFromProfile();
                this.loading = false;
                this.$alertStore.add(error.message, 'error');
            });

    
        }

    }
};
</script>