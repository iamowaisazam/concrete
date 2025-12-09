<template>
    <v-container max-width="1300px" fluid>
        <v-row class="">
            <v-col cols="12" >
                 <v-card>
                    <div class="py-5 d-flex align-center  flex-wrap">
                        <div class="py-2 px-5">
                            <div style="max-width: 150px" >
                                <img style="width: 100px; height:100px" class="border" :src="userStore.user.avatar" />
                            </div>
                        </div>
                        <div class="py-2 " >
                            <div class="pl-3 " >
                                 <h6 class="pb-3 text-h4 font-weight-bold">{{ userStore.user.firstName }}</h6>
                                <div class="d-flex align-center flex-wrap text-light" >
                                    
                                    <div class="pr-3 d-flex align-center" > 
                                        <v-icon icon="mdi-equalizer"/> 
                                        <span class="text-body-2 px-2" >{{ userStore.user.companyName }}</span>
                                    </div>
                                    <div class="px-3 d-flex align-center" > 
                                        <v-icon icon="mdi-briefcase-outline"/> 
                                        <span class="text-body-2 px-2" >{{ userStore.user.jobTitle }}</span>
                                    </div>
                                    <div v-if="userStore.user.plans" class="px-3 d-flex align-center" > 
                                        <v-icon icon="mdi-lightning-bolt"/> 
                                        <span class="text-body-2 px-2 text-capitalize ">{{ userStore.user.plans.membership_type }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </v-card> 
            </v-col>
            <v-col cols="12" md="5" >    
                <Sidebar/>
            </v-col>
            <v-col cols="12" md="7">

                <v-card title="Notification" class="border" >
                    <div class="border-b" ></div>

                          <v-card-text>
                            <p>Notifications...</p>
                        </v-card-text>
                </v-card>
          
                <!-- <RecentDevices/>     -->
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { useUserStore } from '@/stores/userStore';
import RecentDevices from './RecentDevices.vue';
import Sidebar from './Sidebar.vue';
import { changPassword } from '@/services/authService';


export default {
    components: {
    RecentDevices,
    Sidebar
    },
    data() {
        return {
          userStore: useUserStore(),
        };
    },

    computed: {
       
    },
   async mounted() {

       
    //    console.log(res);
       
        
    }
};
</script>



<style>



</style>