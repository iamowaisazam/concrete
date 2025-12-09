<template>
          <v-app-bar class="px-3 px-sm-5" flat>
            <template v-slot:prepend>
                <v-btn to="/">
                    <v-img width="130" :src="logo" to="/"></v-img>
                </v-btn>
            </template>
            <template v-slot:append>
                <v-btn @click="themeStore.toggleThemeMode(vuetify)" v-if="vuetify.global.name == 'adminDark'" icon="mdi-lightbulb-on">
                </v-btn>
                <v-btn @click="themeStore.toggleThemeMode(vuetify)" v-if="vuetify.global.name == 'adminLight'" icon="mdi-lightbulb-off">
                </v-btn>
                <v-btn color="primary" variant="flat" to="/">Back To Home</v-btn>
            </template>
        </v-app-bar>
</template>

<script>

import { useThemeStore } from "@stores/themeStore";
import { useTheme } from "vuetify";
import Logo from "@assets/images/logo/logo.png";


export default {
    name: "AuthHeader",
    components: {

    },
    data() {
        return {
            logo:  new URL('@assets/images/logo/logo.png', import.meta.url).href,
            themeStore: useThemeStore(),
            vuetify: useTheme(),
        };
    },
    computed: {

    },
    methods: {

    },
};
</script>