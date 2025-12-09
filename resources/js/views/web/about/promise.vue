<template>
  <section class="overflow-hidden">
    <v-row no-gutters class="min-vh-100">
      
      <!-- LEFT: Blue Half -->
      <v-col cols="12" lg="6" class="bg-primary d-flex align-center justify-center pa-8 pa-md-16">
        <div class="text-white " style="width: 500px;">
          <h1 class="text-h font-weight-bold">
            Our <br> Promise
          </h1>

          <!-- Black Vertical Line + Points -->
          <div class="position-relative">

            <div  class="mb-1 ml-2" style="border-left:5px solid black ; ">
              <p class="text-body-1 text-black ml-2">
            We don't sell cars. <br>
            We don't push deals. <br>
            We give you the truth behind every auction.           
              </p>
            </div>
          </div>

          <!-- Footer Text -->
          <p class=" text-black mt-10">
            {{ data.footer }}
          </p>
        </div>
      </v-col>

      <!-- RIGHT: Dark Gradient Half -->
      <v-col cols="12" lg="6" class="d-flex align-center justify-center">
        <div
          class="w-100 h-100"
          style="  background: linear-gradient(rgb(0, 14, 32), rgba(0, 128, 225, 0.19));"
        ></div>
      </v-col>

    </v-row>
  </section>
</template>

<script setup>
import { reactive } from 'vue'
import promiseData from '@/json/promise.json'

const data = reactive(promiseData)
</script>

<!-- No <style scoped> needed – pure Vuetify + allowed inline -->