<template>
  <v-card class="rounded-xl pa-6" color="#1e1e2e" elevation="8">
    <!-- Header -->
    <div class="d-flex align-center justify-space-between mb-6">
      <h2 class="text-h6 text-white font-weight-bold">Recent Views</h2>
      <v-btn icon small variant="text" color="grey-lighten-1">
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </div>

    <!-- Recent Cars List -->
    <div v-for="(car, index) in recentCars" :key="index" class="mb-5">
      <div class="d-flex align-start ga-4">
        <!-- Car Image -->
        <v-avatar rounded size="80" class="flex-shrink-0">
          <v-img
            :src="car.image"
            cover
            class="rounded-lg"
          >
            <template v-slot:placeholder>
              <v-icon size="40" color="grey">mdi-car</v-icon>
            </template>
          </v-img>
        </v-avatar>

        <!-- Car Info -->
        <div class="flex-grow-1">
          <h3 class="text-white font-weight-bold text-subtitle-1">{{ car.brand }}</h3>
          <p class="text-grey-lighten-1 text-caption mb-1">{{ car.model }}</p>
          <p class="text-grey-lighten-2 text-caption">Year: {{ car.year }}</p>
        </div>

        <!-- Status Badge -->
        <v-chip
          :color="car.status === 'SOLD' ? 'grey-darken-1' : 'primary'"
          :text-color="car.status === 'SOLD' ? 'grey-lighten-2' : 'white'"
          small
          class="font-weight-bold text-caption px-3"
          rounded
        >
          {{ car.status }}
        </v-chip>
      </div>
    </div>

    <!-- View More Button -->
    <v-btn
      block
      color="primary"
      size="large"
      class="mt-6 rounded-lg text-capitalize font-weight-bold"
      elevation="3"
    >
      View More
    </v-btn>
  </v-card>
</template>

<script>
export default {
  name: 'RecentViewsWidget',

  data() {
    return {
      recentCars: [
        {
          brand: 'BMW',
          model: '3 Series Car',
          year: '2021',
          status: 'SOLD',
          image: 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=400&h=300&fit=crop'
        },
        {
          brand: 'Audi',
          model: 'Q3 Car',
          year: '2012',
          status: 'PROVISIONAL',
          image: 'https://images.unsplash.com/photo-1549317661-02d116e7e3e5?w=400&h=300&fit=crop'
        },
        {
          brand: 'Volvo',
          model: 'V60 Car',
          year: '2017',
          status: 'SOLD',
          image: 'https://images.unsplash.com/photo-1606664510014-9b0cb7d09e82?w=400&h=300&fit=crop'
        }
      ]
    }
  }
}
</script>

<style scoped>
.v-application {
  background: #0f0f1e !important;
}

/* Optional hover effect */
.v-card > div > div:hover {
  opacity: 0.95;
  transition: 0.2s;
}
</style>