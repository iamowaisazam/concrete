<template>
      <div>
          <router-view></router-view>
          <v-overlay :model-value="this.themeStore.loading" :persistent="true" class="align-center justify-center">
            <v-progress-circular color="primary" size="64" indeterminate></v-progress-circular>
          </v-overlay>
          <Alert />
      </div>
</template>

<script>

import { useThemeStore } from './stores/themeStore';
import { useUserStore } from './stores/userStore';
import Alert from '@components/alert.vue'
import Overlay from '@components/overlay.vue'
import { toRaw } from 'vue'
import { useTheme } from 'vuetify';



export default {
  props: {},
  components: {
    Alert,
    Overlay
  },
  data() {
    return {
      themeStore: useThemeStore(),
      userStore: useUserStore(),
      vuetify: useTheme(),
  
    };
  },
  methods: {


  },
  async mounted() {

    
  


  },
};

</script>