<template>
  <section class="bg-surface py-20 overflow-hidden relative pa-14 min-vh-100">
    <v-container class="relative z-10">
      <div class="text-center max-w-3xl mx-auto">
        <h1 class="text-h6 text-lg-h4  text-md-h5 font-weight-bold text-white mb-6">
          {{ bidSmarterData.title }}
        </h1>
        <div class=" d-flex justify-center">
          <p class="text-subtitle-1 text-light_text_on mb-4 " style="max-width: 600px;">
            {{ bidSmarterData.paragraph }}
          </p>
        </div>


        <v-btn size="x-large" class="px-12 text-h6 font-weight-bold" elevation="1"
          style="background:#1976d2; color:black;">
          {{ bidSmarterData.button }}
        </v-btn>
      </div>
    </v-container>

    <div class="images">
      <div class="left"><img :src="leftSideImage" /></div>
      <div class="right"><img :src="leftSideImage" /></div>
    </div>

  </section>
</template>

<script>
import leftSideImage from '@/assets/images/tabs/footerimg.png'
import bidSmarterData from "@/json/bidsmarter.json"
export default {
  data() {
    return {
      leftSideImage,
      bidSmarterData
    }
  }
}
</script>

<style scoped>
.images {
  display: flex;
  width: 100%;
  justify-content: space-between;
  margin-top: -100px;
}

.left {
  rotate: 90deg;
}

@media (max-width: 600px) {
  .images {
    justify-content: space-between !important;
    margin-left: -30px;
    margin-top: 0;
  }

  .images img {
    width: 150px;
  }
}
</style>