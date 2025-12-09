<template>
  <div style=" margin-top: 30px; ">
      <v-row class="mt-6  " align="center" justify="center" no-gutters>
        <v-col cols="2" sm="6" md="3" lg="2" class="text-center">
          <img :src="zoom" class="logo-item" />
        </v-col>

        <v-col cols="12" sm="6" md="3" lg="2" class="text-center">
          <img :src="microsoft" class="logo-item" />
        </v-col>

        <v-col cols="12" sm="6" md="3" lg="2" class="text-center">
          <img :src="teamviewer" class="logo-item" />
        </v-col>

        <v-col cols="12" sm="6" md="3" lg="2" class="text-center">
          <img :src="google" class="logo-item" />
        </v-col>

        <v-col cols="12" sm="6" md="3" lg="2" class="text-center">
          <img :src="slack" class="logo-item" />
        </v-col>
      </v-row>

    </div>
  <div style="max-width: 1600px;" class="mx-auto">
    <!-- Top Logos Section -->
    


    <!-- Vision Section (baki same) -->
    <v-container class="my-16 ">
      <v-row align="center" class="px-4">
        <v-col cols="12" lg="6">
          <v-chip color="primary" label class="mb-4">Vision</v-chip>
          <h1 class="text-h3 font-weight-bold mb-6">
            Our Vision.
            <div class="bg-primary mt-3" style="height: 4px; width: 70px;"></div>
          </h1>
          <div class="text-body-1 text-grey-darken-2 mb-6">
            <p class="mb-4">
              At Autoboli, our vision is simple: To empower dealers and traders with transparent, real-time auction data
              and insights that help them make smarter, faster, and more profitable decisions.
            </p>
            <p>
              We believe in transforming the automotive trade industry with clarity, innovation, and intelligence.
            </p>
          </div>
        </v-col>

        <v-col cols="12" lg="5" offset-lg="1">
          <v-card elevation="12" rounded="xl" class="pa-10 text-start" color="white">
            <h2 class="text-h4 font-weight-black" style="line-height: 1.3;">
              <span class="text-primary">Save people </span><br>
              <span class="text-primary">time</span> by making<br>
              the world more<br>
              <span class="text-primary">productive</span>.
            </h2>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>

  <!-- <keyfeatures/> -->
</template>

<script>
import zoom from '@/assets/images/logo/zoom.png'
import microsoft from '@/assets/images/logo/mslogo.png'
import teamviewer from '@/assets/images/logo/teamviewer.png'
import google from '@/assets/images/logo/googlelogo.png'
import slack from '@/assets/images/logo/slacklogo.png'
import screen from './screen.vue'
import keyfeatures from './keyfeatures.vue'

export default {
  name: 'VisionSection',
  data() {
    return {
      zoom,
      microsoft,
      teamviewer,
      google,
      slack
    }
  },
  components: {
    screen,
    keyfeatures
  }
}
</script>

<style scoped>
.logo-container {
  display: flex;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: center;
  gap: 10rem;
  overflow-x: auto;
  padding: 1rem 0;
  scrollbar-width: none;
}

.logo-container::-webkit-scrollbar {
  display: none;
}

.logo-item {
  height: 70px;
  width: auto;
  opacity: 0.7;
  transition: all 0.3s ease;
  flex-shrink: 0;
}

.logo-item:hover {
  opacity: 1;
  transform: translateY(-4px);
}

.logo-container {
  display: flex;
  flex-wrap: wrap;

  justify-content: center;
  gap: 7rem;
}

.logo-item {
  max-width: 120px;
  width: 100%;
  object-fit: contain;
}

@media (max-width: 600px) {
  .logo-item {
    flex: 0 0 45%;
    margin-bottom: 1.5rem;
  }
}

/* Tablet & Mobile pe gap thoda kam kar do */
@media (max-width: 1260px) {
  .logo-container {
    gap: 3rem;
  }
}

@media (max-width: 960px) {
  .logo-container {
    gap: 2rem;
  }
}

@media (max-width: 600px) {
  .logo-container {
    gap: 1.5rem;
  }
}
</style>