<template>
    <main>
        <user-title-bar
            title="Dashboard Overview"
            subtitle="Monitor your stats and activities here"
        ></user-title-bar>
    </main>
</template>


<script>

import { useThemeStore } from "../../stores/themeStore";
import { useUserStore } from "../../stores/userStore";


export default {
    props: {},
    components: {
   
    },
    data() {
        return {
            themeStore: useThemeStore(),
            userStore:useUserStore(),
        };
    },
    methods: {
      
    },
    mounted() {     
        
        this.userStore.$subscribe((mutation, state) => {
            console.log('New state:', state.user)
        });

    },
};

</script>

<style scoped>

</style>
