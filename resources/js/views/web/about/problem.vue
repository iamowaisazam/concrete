<template>
  <section class="bg-background ">
    <v-container class="py-16 py-md-20">
      <v-row align="center" justify="center" class="min-vh-100" no-gutters>

        <!-- Left Big Card -->
        <v-col cols="12" lg="6" class="d-flex justify-center mb-8 mb-lg-0">
          <v-card class="pa-10 pa-md-16 text-center" max-width="860" color="#0f172a" :border="true"
            style="border: 10px solid #7f1d1d !important; border-radius: 90px;">
            <h1 class="text-h2 text-md-h1 font-weight-black text-white mb-4">
              The <span class="text-white bg-red-darken-2 px-4" style="border-radius: 8px;">Real</span>
            </h1>
            <h1 class="text-h2 text-md-h1 font-weight-black text-white mb-6">
              <span class="bg-red-darken-2 text-white px-6 py-2" style="border-radius: 12px; display: inline-block;">
                Problem
              </span>
            </h1>
            <h2 class="text-h6 text-lg-h4  text-md-h5 font-weight-bold text-white">
              in Auctions
            </h2>
          </v-card>
        </v-col>

        <!-- Right Side Content -->
        <v-col cols="12" lg="6" class="d-flex justify-center">
          <div class="text-center" style="max-width: 600px; width: 100%;">
            <!-- Top Text -->
            <p class="text-body-1 text-light_text_on mb-2">The truth is simple:</p>
            <p class="text-h6 text-white font-weight-medium mb-10">
              People don’t lose money because the market is bad.<br>
              They lose money because they bid blind.
            </p>

            <!-- Problem Cards -->
            <div v-for="(item, i) in problems" :key="i" class="mb-6">
              <v-card class="d-flex align-center pa-5 position-relative border-lg border-danger bg-surface mx-auto"
                rounded="xl" elevation="8">
                <!-- Red Minus Icon -->
                <v-icon class="bg-danger text-h3 font-weight-bold rounded-lg mr-4" size="36">
                  mdi-minus
                </v-icon>

                <p class="text-body-1 text-white mb-0">
                  {{ item.text }}
                </p>
              </v-card>
            </div>

            <v-card class="d-flex align-center pa-5 position-relative border-lg bg-primary mx-auto" rounded="xl"
              elevation="8">
              <v-icon class="bg-black text-white text-h3 font-weight-bold rounded-lg mr-4" size="36">mdi-plus</v-icon>
              <p class="text-body-1 text-white mb-0">{{ solution.text }}</p>
            </v-card>
          </div>
        </v-col>

      </v-row>
    </v-container>
  </section>
</template>

<script>
import problem from '@/json/realproblem.json'

export default {
  name: "ProblemPage",
  data() {
    return {
      problems: problem.problems,
      solution: problem.solution
    }
  }
}
</script>

<style scoped>
.bg-red-darken-2 {
  background: #7f1d1d !important;
}
</style>
