<template>
    <v-app  >
      
        <Sidebar />
        <v-app-bar elevation="0" color="surface" class="d-flex align-center justify-space-between elevation-3 border-b" style="height: 70px;">
            <v-app-bar-nav-icon class="d-lg-none" @click="themeStore.toggleMenu()"></v-app-bar-nav-icon>
            <div elevation="1" class="logoType d-none d-lg-flex align-center justify-center rounded-circle border" style="width: 30px; height: 30px;" >
                <v-icon color="" class=" d-none d-lg-inline-flex justify-center align-center" size="default" :icon="isMenuOpen ? 'mdi-menu-left' : 'mdi-menu-right'" 
                @click="toggleMenu"></v-icon>
            </div>
           
            <v-toolbar-title class="d-none d-sm-inline pl-1">
                <p class="text-18">Dashboard</p>
            </v-toolbar-title>

            <v-spacer></v-spacer>
            
            <v-row class="d-flex align-center justify-end" no-gutters>

                <div class="d-flex align-center justify-space-around mr-0 mr-lg-3">
                    <!-- Fullscreen -->
                    <v-col cols="auto">
                        <v-sheet color="" class="d-flex align-center justify-center rounded pa-2 border">
                            <v-icon icon="mdi-fullscreen" class="cursor-pointer" @click="toggleFullScreen"></v-icon>
                        </v-sheet>
                    </v-col>

                    <!-- Theme Dropdown -->
                    <!-- <v-col cols="auto" class="ml-n3">
                        <v-sheet color="" class="d-flex align-center justify-center rounded border">
                            <ThemeDropdown />
                        </v-sheet>
                    </v-col> -->

                    <!-- Notification Dropdown -->
                    <!-- <v-col cols="auto" class="ml-n3">
                        <v-sheet color="" class="d-flex align-center justify-center rounded border">
                            <Notificationdropdown class="test" />
                        </v-sheet>
                    </v-col> -->

                    <v-col cols="auto" class="ml-n3">
                        <ProfileDropdown>
                        </ProfileDropdown>
                    </v-col>
                </div>
            </v-row>
        </v-app-bar>

        <!-- Main Content -->
        <v-main class="bg-background">
            <v-container fluid >
                 <router-view></router-view>
            </v-container>
           
        </v-main>
    </v-app>
</template>

<script>
import Sidebar from "./Sidebar/index.vue";
import ProfileDropdown from "./ProfileDropdown.vue";
import Notificationdropdown from "./Notificationdropdown.vue";

import { mdiFullscreen } from "@mdi/js";

import { useThemeStore } from "@stores/themeStore";
import ThemeDropdown from "./ThemeDropdown.vue";

export default {
    name: "App",
    components: {
        Sidebar,
        ProfileDropdown,
        Notificationdropdown,
        ThemeDropdown,
    },
    computed: {},
    data() {
        return {
            drawer: true,
        
            themeStore: useThemeStore(),
            path: mdiFullscreen,
            isMenuOpen: false,
        };
    },
    methods: {
        toggleFullScreen() {
            if (!this.isFullScreen) {
                const element = document.documentElement;
                if (element.requestFullscreen) {
                    element.requestFullscreen();
                } else if (element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                } else if (element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                } else if (element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }

            this.isFullScreen = !this.isFullScreen;
            this.path = this.isFullScreen ? mdiFullscreenExit : mdiFullscreen;

        },
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
            this.themeStore.toggleMenuType();
        },
    },
};
</script>
<style scoped >
.v-overlay__content {
    top: 75px !important;
}
</style>
