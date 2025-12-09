<template>
  <div class="hero-wrapper">
    <div class="hero-card">
      <!-- Left Content -->
      <div class="left-content bg-primary pa-8 pa-md-16 d-flex flex-column justify-center">
        <h1 class="text-body-2 text-md-h2 text-lg-h3 font-weight-black text-white mb-6 leading-tight">
          Start <span class="text-grey-lighten-2">Winning</span> Smarter,<br>
          Not Harder.
        </h1>

        <p class="text-body-1 text-white opacity-90 mb-10 max-w-lg">
          Join Autoboli today and experience the power of intelligent auction insights.
        </p>

 <v-btn
  size="x-large"
  color="white"
  class="font-weight-bold text-primary text-button "
  elevation="12"
   style="width:400px;"
>
  <span class="d-flex align-center justify-center text-capitalize">
    Get started. It's FREE
    <v-icon class="ml-3" size="large">mdi-arrow-right</v-icon>
  </span>
</v-btn>
      </div>

      <!-- Right Mockup Image -->
      <div class="right-image d-flex align-center justify-center pa-8" >
        <img
          :src="winingLeftImage"
          alt="Autoboli Dashboard"
          class="dashboard-mockup"
        />
      </div>
    </div>
  </div>
</template>

<script>
import winingLeftImage from '@/assets/images/tabs/wining.png'

export default {
  name: 'HeroSection',
  data() {
    return {
      winingLeftImage
    }
  }
}
</script>

<style scoped>
.hero-wrapper {
 

  min-height: 80vh;
  display: flex;
  align-items: center;
}

.hero-card {
  max-width: 1550px;
  margin: 0 auto;
  height: 400px;
  background: transparent;
  border-radius: 32px;
  overflow: hidden;
  display: flex;
  flex-direction: row;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
  position: relative;
}

/* Left Side */
.left-content {
  flex: 1;
  min-width: 300px;

}

/* Right Side - Image */
.right-image {
  flex: 1;
  overflow: hidden;
}



/* Responsive */
@media (max-width: 960px) {
  .hero-card {
    flex-direction: column;
    height: auto;
    border-radius: 24px;
  }
  
  .right-image {
    border-radius: 0 0 24px 24px;
    padding: 4rem 2rem 6rem !important;
  }

  .dashboard-mockup {
    transform: rotate(0deg) scale(1);
    max-width: 90%;
  }

  .hero-wrapper {
    min-height: 100vh;
    padding: 6rem 1rem;
  }
}
</style>