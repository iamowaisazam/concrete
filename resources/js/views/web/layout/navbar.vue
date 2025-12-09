<template>
    <v-container class="navbar bg-surface pa-0" style="max-width: 100%; height: 80px; position: fixed; z-index: 10;">
        <v-container class="pa-0 d-flex align-center justify-space-between" style="height: 80px; max-width: 1500px;">

            <!-- NAV -->
            <nav class="d-flex align-center justify-space-between w-100">

                <!-- Logo -->
                <div class="d-flex align-center">
                    <v-list-item>
                        <img :src="logo" height="30px" />
                    </v-list-item>
                </div>

                <!-- NAV MENU (Desktop) -->
                <div class="d-none d-lg-flex align-center">
                    <v-list-item v-for="(item, index) in navMenu" :key="index" :to="item.path" link class="mx-3">
                        <v-list-item-title class="text-capitalize text-body-2">
                            {{ item.label }}
                        </v-list-item-title>
                    </v-list-item>
                </div>

                <!-- RIGHT BUTTONS -->
                <div class="d-flex align-center">
                    <!-- Theme Toggle -->
                    <v-list-item  class="pa-2">
                        <v-icon @click="toggleTheme" link :color="'primary'">
                            {{ isDark ? 'mdi-weather-night' : 'mdi-white-balance-sunny' }}
                        </v-icon>
                    </v-list-item>

                    <!-- Login -->
                    <v-list-item v-if="userStore.user" to="/login" link class="pa-2   d-none d-lg-flex">
                        <v-btn variant="plain" class="text-capitalize">
                            SignIn
                        </v-btn>
                    </v-list-item>

                    <!-- Dashboard -->
                    <v-list-item v-if="userStore.user" to="/user/dashboard" link class="pa-0 ma-0 d-none d-lg-flex">
                        <v-btn variant="outlined" class="border-thin text-capitalize bg-shadow hover:bg-primary">
                            Get Started
                        </v-btn>
                    </v-list-item>

                    <!-- Hamburger icon for mobile -->
                    <v-app-bar-nav-icon class="d-lg-none" @click="drawer = !drawer" />
                </div>

            </nav>

            <!-- Mobile Drawer -->
            <v-navigation-drawer v-model="drawer" temporary class="d-lg-none mt-14">
                <v-list>
                    <v-list-item v-for="(item, index) in navMenu" :key="index" :to="item.path" link>
                        <v-list-item-title>{{ item.label }}</v-list-item-title>
                    </v-list-item>

                </v-list>
                <div class="d-flex"><v-list-item v-if="userStore.user" to="/login" link
                        class="pa-2 ma-0 d-lg-none d-flex">
                        <v-btn variant="plain" class="text-capitalize">
                            SignIn
                        </v-btn>
                    </v-list-item>
                    <v-list-item v-if="userStore.user" to="/user/dashboard" link class="pa-0 ma-0 d-lg-none d-flex">
                        <v-btn variant="outlined" class="border-thin text-capitalize bg-shadow hover:bg-primary">
                            Get Started
                        </v-btn>
                    </v-list-item>
                </div>
            </v-navigation-drawer>

        </v-container>

        <div class="bg-shadow mx-auto" style="height: 0.5px; width: 100%"></div>
    </v-container>
</template>

<script>
import logo from '@/assets/images/logo/logo.png'
import navbarItem from "@/enums/WebHeaderMenu"
import { useUserStore } from '@/stores/userStore';
import { useTheme } from "vuetify";

export default {
    data() {
        return {
            userStore: useUserStore(),
            drawer: false,
            navMenu: navbarItem,
            logo: logo,
            vuetify: useTheme(),
        }
    },
    computed: {
        isDark() {
            return this.vuetify.global.name === "adminDark"
        }
    },
    methods: {
        toggleTheme() {
            this.vuetify.change(this.isDark ? "adminLight" : "adminDark")
        }
    }
}
</script>

<style scoped>
.navbar {
    z-index: 10;
}
</style>