<template>
  <v-app>

    <Navbar v-if="$route.path !== '/support'" />

    <v-main class="bg-background">
      <router-view></router-view>
    </v-main>

    <Footer v-if="$route.path !== '/support'" />
  </v-app>
</template>

<script>
import Footer from './footer.vue';
import Navbar from './navbar.vue';

export default {
  name: "App",
  components: { Navbar, Footer }
}
</script>
