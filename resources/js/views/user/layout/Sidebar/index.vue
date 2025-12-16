<template>
    <v-navigation-drawer  
        @click="MenuClick"
        class="pa-0" 
        color="nav" 
        :width="menuWidth" 
        v-model="themeStore.menuOpen">
        
        <v-list density="compact" class="ps" nav>
           
            <v-list-item class="d-flex ps-5 pe-5" style="height: 57px;">
                <img :src="logo" class="d-flex justify-center align-center" />
            </v-list-item>

         

            <v-divider class="ps-0 pe-0"></v-divider>
            <div class="mt-3" ></div>

            <!-- Dynamic Menu Items -->
            <template v-for="(item, index) in menus" :key="index">

                <v-list-group :value="item.label" v-if="item?.children">
                    <template #activator="{ props }">
                        <v-list-item 
                          v-bind="props" 
                          :title="item.label" 
                          :prepend-icon="item.icon" />
                    </template>
                    <v-list-item v-for="child in item.children" :title="child.label" :to="child.path" />
                </v-list-group>

                <v-list-item  v-else
                    :to="item.path" 
                    link 
                    :prepend-icon="item.icon" 
                    :ripple="false"
                    :hide-overlay="false"
                    class=""
                    active-class="bg-primary on-primary  rounded my-active-menu hide-overlay">
                    <template #title>
                        <span :ripple="false" class="">{{ item.label }}</span>
                    </template>
                </v-list-item>

            </template>

              

        </v-list>
    </v-navigation-drawer>
</template>

<script>
import { useDisplay } from "vuetify";
import { useThemeStore } from "@stores/themeStore";
import Menus from "./menu";
import logo from "@assets/images/logo/logo.png"
export default {
    data() {
        return {
            menus: Menus,
            themeStore: useThemeStore(),
            display: useDisplay(),
            logo: logo,
        };
    },
    computed: {
        menuWidth() {
            
            // md, sm, xs
            if (this.display.mdAndDown) {
                return  "258";
            } else {
                //for: lg, xl
                return this.themeStore.menuType == "expanded" ? "258" : "68";
            }

        },
        
    },
    methods: {
        MenuClick() {
            console.log("Hovered IN");
           // your code here
           this.themeStore.menuType = "expanded";
        },
        onHoverOut() {
            console.log("Hovered OUT");
            // your code here
            // this.themeStore.menuType = "collapsed";
        }
    },
    
};
</script>
<style >






/* Alternative (more future-proof) – target the actual overlay class */
.my-active-menu  .v-list-item__overlay {
  display: none !important;
}


</style>
