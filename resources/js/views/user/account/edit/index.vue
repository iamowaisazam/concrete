<template>

    <v-row no-gutters >
        <!-- <v-col col="12" >
              <div class=" d-flex flex-wrap">
                    <div class="">
                        <v-btn class="text-capitalize"
                            :class="{ 'bg-primary': activeTab == 'profile' } " 
                            variant="flat"
                            @click="activeTab = 'profile'"
                            prepend-icon="mdi-eye" >Account</v-btn>
                    </div>
                </div>
        </v-col> -->
        <v-col cols="12">
            <component v-if="currentComponent" :is="currentComponent" :id="this.$route.params.id" />
        </v-col>
    </v-row>
</template>

<script>
import UserModel from '@/models/user.model';
import { toRaw } from 'vue';
import profile from "./profile.vue";

export default {
    components: {
        profile,
    },
    data() {
        return {
            activeTab: 'profile',
            id:this.$route.params.id,
        };
  },
   computed: {
        currentComponent() {
            switch (this.activeTab) {
                case "profile":
                    return profile
                default:
                    return '' 
            }
        },
        
    },
    mounted(){
 
    },
    methods: {

   

  },
};
</script>


<style>

  
</style>