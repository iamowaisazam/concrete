<template>
  <div class="bg-surface pa-16">
    <v-container style="max-width: 1500px; margin: auto;">
      
      <div class="text-center mb-12">
        <h2 class="text-h6 text-lg-h4  text-md-h5 font-weight-bold text-white mb-4">
          {{ title }}
        </h2>

        <p class="text-subtitle-1 text-grey-lighten-1 max-w-800 mx-auto">
          {{ subtitle }}
        </p>
      </div>

      <v-row>
        <v-col
          v-for="(item, index) in cards"
          :key="index"
          cols="12"
          sm="6"
          md="4"
        >
          <v-card class=" rounded-xl">
            
            <v-img
              height="200"
              src="https://cdn.vuetifyjs.com/docs/images/cards/purple-flowers.jpg"
              cover
            />

            <v-card-text style="background-color: rgb(275, 275, 275 , 0.1);">
              <v-timeline align="start" density="compact">
                <v-timeline-item>

                  <strong>{{ item.title }}</strong>
                  <div>{{ item.desc }}</div>

                  <v-btn
                    v-if="item.hasButton"
                    size="small"
                    color="primary"
                    variant="flat"
                  >
                    {{ item.buttonText }}
                  </v-btn>

                </v-timeline-item>
              </v-timeline>
            </v-card-text>

          </v-card>
        </v-col>

      </v-row>
    </v-container>
  </div>
</template>

<script>
import autoboliCardContent from '@/json/different.json'

export default {
  data() {
    return {
      title: autoboliCardContent.title,
      subtitle: autoboliCardContent.subtitle,
      cards: autoboliCardContent.cards   
    }
  }
}
</script>

<style scoped>
.gap-2px {
  gap: 2px !important;
}
</style>
