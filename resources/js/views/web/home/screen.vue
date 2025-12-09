<template>

  <div class="bg-surface  " style="height: 100vh;">
    <div class="dashboard-mockup ">
      <img :src="screenRight" alt="AutoBoli Dashboard" class="dashboard-img" style="max-width: 960px;" />
    </div>
    <div style="max-width: 1500px;" class="mx-auto">
      <v-row>
        <v-col cols="12">

          <div class="d-flex h-screen content-wrapper
               flex-column flex-md-row   
               align-center         
               justify-center justify-md-start 
      ">

            <!-- LEFT TEXT SECTION -->
            <div class="text-section
                 text-center text-md-left  
          ">

              <!-- Trust Badge -->
              <div class="trust-badge mb-8 rounded-xl d-flex border border-white
                   w-75 w-md-25              
                   mx-auto mx-md-0             
          " style="padding: 2px; height: 40px; background-color: rgba(255, 255, 255, 0.2);">
                <div class="avatar-stack ">
                  <v-avatar size="30" class="avatar-item border border-white">
                    <v-img :src="avatar1" />
                  </v-avatar>
                  <v-avatar size="30" class="avatar-item border border-white">
                    <v-img :src="avatar2" />
                  </v-avatar>
                  <v-avatar size="30" class="avatar-item border border-white">
                    <v-img :src="avatar3" />
                  </v-avatar>
                </div>

                <span class="text-caption text-md-body-2 text-white ml-2 mt-2">
                  3,000+ dealers trust AutoBoli
                </span>
              </div>

              <!-- MAIN TITLE -->
              <h1 class="text-h5 text-md-h3 text-lg-h3
                   text-white font-weight-bold mb-6 lh-1
                   text-center text-md-left   
          ">
                Smarter Vehicle Auction <br />
                Insights - All in One Place
              </h1>

              <!-- Description -->
              <p class="text-body-2 text-md-body-1 text-light_text_on mb-10
                   w-100 w-md-50             
                   mx-auto mx-md-0           
                   text-center text-md-left  
          ">
                Stay ahead of the market with real-time UK vehicle auction data,
                transparent valuations, and powerful tools designed for dealers,
                traders, and smart buyers.
              </p>

              <!-- CTA Buttons -->
              <div class="d-flex flex-wrap ga-4 mb-8
                   justify-center justify-md-start   <!-- mobile center -->
          ">

                <v-btn color="primary" size="large" class="px-8 text-body-2 text-md-subtitle-1 font-weight-bold">
                  Explore Auctions
                </v-btn>

                <v-btn variant="outlined" size="large"
                  class="px-8 text-body-2 text-md-subtitle-1 text-white font-weight-bold border-1"
                  style="background-color: rgba(255, 255, 255, 0.2);">
                  Start Free Trial
                </v-btn>

              </div>

              <!-- Bottom Text -->
              <p class="text-caption text-md-body-2 text-grey-lighten-3
                    text-center text-md-left  <!-- mobile center -->
          ">
                No card required • Cancel anytime • UK & JP auction coverage
              </p>

            </div>

          </div>

        </v-col>
      </v-row>
    </div>

  </div>

</template>

<script>
import screenRight from '@/assets/images/reauction/Reauction.png'
import avatar1 from '@/assets/images/avatar/avatar1.png'
import avatar2 from '@/assets/images/avatar/avatar2.png'
import avatar3 from '@/assets/images/avatar/avatar3.png'

export default {
  name: 'HeroSection',
  data() {
    return {
      screenRight,
      avatar1,
      avatar2,
      avatar3
    }
  }
}
</script>

<style scoped>
.dashboard-mockup {
  position: absolute;
  top: 90px;
  right: 0;
  height: 600px;
  /* overflow: hidden; */
  pointer-events: none;
  overflow: hidden;
}

@media (max-width: 1400px) {

  .dashboard-mockup {
    position: absolute;
    top: 90px;
    right: 0;
    width: 600px;
    height: 600px;
    /* overflow: hidden; */
    pointer-events: none;
    overflow: hidden;
  }

}

@media (max-width: 1024px) {
  .dashboard-mockup {
    position: absolute;
    top: 90px;
    right: 0;
    display: none;
    height: auto;
    pointer-events: none;
  }
}

@media (max-width: 600px) {
  .dashboard-mockup {

    right: 10px;
    background-color: aliceblue;
  }
}
</style>