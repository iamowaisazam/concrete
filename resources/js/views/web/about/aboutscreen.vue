<template>

    <main>

  <!-- HERO -->
  <section
    class="aboutScreen d-flex justify-center "
    style="height: 60vh; background: linear-gradient(to right, #2163a6, #0080ff);"
  >
    <v-container style=" max-width:1400px;  max-height: 403px;" class="mt-14">

      <div style="max-width: 1000px; margin-top: 20px;"><!-- small text responsive -->
      <span class="font-weight-medium text-black text-subtitle-2 text-sm-subtitle-1">
        About Us
      </span>

      <!-- RESPONSIVE MAIN HEADING -->
      <h1
        class="text-white font-weight-bold
               text-h4         
               text-sm-h3       
               text-md-h2     
               text-lg-h2      
               text-xl-h1"      
        style="line-height: 1.1"
      >
        Empowering Dealers & Traders 
        with Data Backed Confidence
      </h1></div>

    </v-container>
  </section>

</main>

  
</template>

<script>

export default {
  name: "AboutPage",

  data() {
    return {
      hoverIndex: null,
    //   image
    };
  }
};

</script>
<style scoped>
@media (max-width: 600px) {
  .aboutScreen {
    height: 30vh; 
  }
}

</style>