<template>
    <v-col cols="12">

        <v-card title="Change Password" class="bg-surface">
             <div class="border" ></div>
            <v-container fluid>

                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field 
                            append-inner-icon="mdi-eye" 
                            label="Current Password"
                            v-model="form.current_password" 
                            :type="toggle_password ? 'text' : 'password'"
                            @click:append-inner="toggle_password = !toggle_password" 
                            variant="outlined" 
                            color="primary"
                            density="compact" />

                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field append-inner-icon="mdi-eye" label="New Password" v-model="form.new_password"
                            :type="toggle_new_password ? 'text' : 'password'"
                            @click:append-inner="toggle_new_password = !toggle_new_password" variant="outlined"
                            color="primary" density="compact" />

                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field append-inner-icon="mdi-eye" label="Confirm New Password"
                            v-model="form.confirm_password" :type="toggle_confirm_Password ? 'text' : 'password'"
                            @click:append-inner="toggle_confirm_Password = !toggle_confirm_Password" variant="outlined"
                            color="primary" density="compact" />
                    </v-col>

                    <v-col cols="12">
                        <h4 class="text-h6 font-weight-thin">Password Requirements:</h4>
                        <ul class="pt-2 ml-5 text-body-2 font-weight-thin">
                            <li class="py-1">Minimum 8 characters long - the more, the better</li>
                            <li class="py-1">At least one lowercase character</li>
                            <li class="py-1">At least one number, symbol, or whitespace character</li>
                        </ul>

                        <div class="my-3">
                            <v-btn @click="formSubmit" class="bg-primary mr-2" variant="flat">Save Changes</v-btn>
                        </div>

                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-col>

    <v-col cols="12">
        <v-card title="Recent Devices" class="">
            <div class="border" ></div>
            
            <v-data-table-server 
                class="pb-3" 
                :headers="headers"
                :items="data" 
                :items-length="data.length"
                item-value="id">
                <template #item.platform="{ item }">
                    <p>
                        <v-icon class="text-primary" icon="mdi-microsoft-windows-classic" />
                        <span class="px-2 font-weight-thin"> {{ item.platform }}</span>
                    </p>
                </template>
                <template #item.browser="{ item }">
                    <p>
                        <v-icon class="text-orange" icon="mdi-google-chrome" />
                        <span class="px-2 font-weight-thin"> {{ item.browser }}</span>
                    </p>
                </template>

                <template v-slot:bottom>
                    <!-- <div class="py-2">
                        <custom-pagination :loading="pageStore.recentDevices.loading"
                            v-model:page="pageStore.recentDevices.page" :lastPage="pageStore.recentDevices.last_page" />
                    </div> -->
                </template>
            </v-data-table-server>
        </v-card>

    </v-col>
</template>
<script>
import {useUserStore} from '@/stores/userStore';
import {usePageStore} from '@/stores/pageStore';
import { changPassword } from '@/services/authService';

export default {
    components: {

    },
    data() {
        return {
            userStore: useUserStore(),
            pageStore: usePageStore(),
            toggle_password: true,
            toggle_new_password: true,
            toggle_confirm_Password: true,
            loading: false,
            form: {
                current_password:'',
                new_password: '',
                confirm_password:'',
            },
            data: [
                {
                 platform:'Windows',
                 browser:'Chrome',
                 device:'Desktop',
                 location:'Not found',
                 recent_activities:'21, November 2025 11:35'   
                },
                {
                 platform:'Windows',
                 browser:'Chrome',
                 device:'Desktop',
                 location:'Not found',
                 recent_activities:'21, November 2025 11:35'   
                }
            ],
            headers: [
                { title: "Platform", key: "platform",sortable:false },
                { title: "Browser", value: "browser" },
                { title: "Device", value: "device" },
                { title: "Location", value: "location" },
                { title: "Date", key: "created_at",sortable:false },
            ],
        };
    },
    computed: {

    },
    mounted() {

        this.data = this.userStore.user.userDevices;

    },
    methods: {
   
        async formSubmit() {
            try {
                let res = await changPassword({
                    current_password: this.form.current_password,
                    new_password: this.form.new_password,
                    new_password_confirmation: this.form.confirm_password
                });
                
                this.$alertStore.add("Password Changed", 'success');
                this.form.current_password = '';
                this.form.new_password = '';
                this.form.confirm_password = '';


            } catch (error) {
                this.$alertStore.add(error.message, 'error');
          
            }
        }
    }
};
</script>
