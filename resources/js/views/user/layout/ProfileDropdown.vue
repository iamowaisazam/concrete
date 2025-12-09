<template>
    <v-menu class="menuLabel" location="bottom" transition="fade-transition">
        <template #activator="{ props }">
            <v-btn icon v-bind="props" class="profileBtn">
                <div class="d-flex align-center ga-2">
                    <div class="profileImage d-flex justify-center align-center">
                        <img :src="userStore.user.avatar" alt="" class="rounded"
                            style="height: 80%; width: 80%;" />
                    </div>
                    <slot></slot>
                </div>
            </v-btn>
        </template>
        
        <v-list elevation="0" class="border" style="min-width: 224px">
            <v-list-item class="pa-3">
                <v-list-item-title class="cursor-pointer">
                    <div class="d-flex justify-start align-center ps-2 ga-2">
                        <div class="profileImage d-flex justify-center align-center">
                            <img :src="userStore.user.avatar" class="h-100 w-100 rounded position-static" />
                        </div>
                        <div>
                            <p class="profile-name text-subtitle-1">
                                {{ userStore.user.title }}
                            </p>
                            <p class="profile-type text-caption text-light_text_on mt-n2">
                                {{ userStore.user.role }}
                            </p>
                        </div>
                    </div>
                </v-list-item-title>
            </v-list-item>
            <!-- <v-divider></v-divider> -->
            <!-- <v-list-item link>
                <v-list-item-title class="cursor-pointer">
                    <router-link to="/user/settings/profile" class="text-decoration-none" >
                        <div class="d-flex align-center ga-2 wrapper">
                            <v-icon icon="mdi-account-outline text-light_text_on"></v-icon>
                            <p class="text-light_text_on">My Profile</p>
                        </div>
                    </router-link>
                </v-list-item-title>
            </v-list-item> -->
            <!-- <v-list-item link>
                <v-list-item-title class="cursor-pointer">
                    <router-link to="/user/settings/security" class="text-decoration-none" >
                        <div class="d-flex align-center ga-2">
                            <v-icon icon="mdi-cog-outline text-light_text_on"></v-icon>
                            <p class="text-light_text_on">Settings</p>
                        </div>
                    </router-link>
                </v-list-item-title>
            </v-list-item> -->
            <!-- <v-list-item link>
                <v-list-item-title class="cursor-pointer">
                    <router-link to="/user/settings/billing" class="text-decoration-none" >
                        <div class="d-flex align-center ga-2 ">
                            <v-icon icon="mdi-credit-card-outline text-light_text_on"></v-icon>
                            <p class="text-light_text_on">Billings</p>
                        </div>
                    </router-link>
                </v-list-item-title>
            </v-list-item> -->
            <v-divider></v-divider>
            <v-list-item>
                <v-list-item-title class="">
                    <!-- <v-btn @click="logOut()" size="large" class="ml-n3" prepend-icon="mdi-logout"
                        style="font-size: smaller;">
                        <p class="">Logout</p>
                    </v-btn> -->
                    <div @click="logOut()" class="d-flex align-center ga-2 cursor-pointer">
                        <v-icon icon="mdi-logout text-light_text_on"></v-icon>
                        <p class="text-light_text_on">Logout</p>
                    </div>
                </v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>
<script>
import { useUserStore } from '@stores/userStore'

export default {
    name: "my-component",
    data() {
        return {
            userStore: useUserStore(),
        };
    },
    methods: {
        logOut() {
            localStorage.removeItem("auth_token");
            this.$alertStore.add("Logged Out Successfully", "success");
            this.$router.push("/login");

        }
    }
};
</script>
<style scoped >
.profileImage {
    height: 45px;
    width: 45px;
}
</style>
