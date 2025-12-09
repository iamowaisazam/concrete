<template>
    <v-menu class="menuLabel" location="bottom" transition="fade-transition">
        <template #activator="{ props }">
            <v-btn size="small" :icon="isDark ? 'mdi-lightbulb-off' : 'mdi-lightbulb-on'" v-bind="props" />
        </template>

        <v-list elevation="0" class="border" style=" margin-left: -100px;">
            <!-- Light Theme -->
            <v-list-item @click="toggleTheme" link>
                <template #prepend>
                    <v-icon :color="isLight ? 'primary' : 'grey-lighten-1'">mdi-lightbulb-on</v-icon>
                </template>
                <v-list-item-title class="cursor-pointer">
                    Light Theme
                </v-list-item-title>
            </v-list-item>

            <!-- Dark Theme -->
            <v-list-item @click="toggleTheme" link>
                <template #prepend>
                    <v-icon :color="isDark ? 'primary' : 'grey-lighten-1'">
                        mdi-lightbulb-off
                    </v-icon>
                </template>
                <v-list-item-title class="cursor-pointer">
                    Dark Theme
                </v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>
<script>
import { useTheme } from "vuetify";

export default {
    name: "IconMenu",
    data() {
        return {
            vuetify: useTheme(),
        };
    },
    computed: {
        isDark() {
            return this.vuetify.global.name === "adminDark";
        },
        isLight() {
            return this.vuetify.global.name === "adminLight";
        },
    },
    methods: {
        toggleTheme() {
            this.vuetify.change(this.isDark ? "adminLight" : "adminDark");
        },
    },
};
</script>
