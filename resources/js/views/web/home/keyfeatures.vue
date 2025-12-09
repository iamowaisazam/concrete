<template>
  <v-container fluid class="py-16 d-flex justify-center">
    <v-row class="keyfeatures-wrapper" align="center" justify="center" no-gutters>
      <v-col cols="12" class="text-center mb-12">
        <h2 class="text-h4 font-weight-bold mb-10">Key Features</h2>
      </v-col>

      <!-- LEFT CARDS -->
      <v-col cols="12" md="6" class="d-flex flex-column justify-center align-end left-cards">
        <v-card class="keyfeature-card mb-10" elevation="12">
          <v-img :src="keyfeatureImages" height="200px" class="rounded-t-lg" />
          <v-card-title class="text-h6 font-weight-bold">Live Auction Insights</v-card-title>
          <v-card-text>
            Track upcoming, live, and historical auctions with complete transparency. See what’s selling, at what price,
            and where.
          </v-card-text>
        </v-card>

        <v-card class="keyfeature-card mb-10" elevation="12">
          <v-img :src="keyfeatureImages" height="200px" class="rounded-t-lg" />
          <v-card-title class="text-h6 font-weight-bold">Advance Auction Finder</v-card-title>
          <v-card-text>
            Filter through thousands of auction lots with smart search tools to find exactly what you’re looking for.
          </v-card-text>
        </v-card>

        <v-card class="keyfeature-card mb-10" elevation="12">
          <v-img :src="keyfeatureImages" height="200px" class="rounded-t-lg" />
          <v-card-title class="text-h6 font-weight-bold">Auction Schedules</v-card-title>
          <v-card-text>
            Plan ahead with a calendar view of upcoming auctions. Bookmark events, filter by region or type, and set up
            alerts.
          </v-card-text>
        </v-card>
      </v-col>

      <!-- RIGHT CARDS -->
      <v-col cols="12" md="6" class="d-flex flex-column justify-center right-cards">
        <v-card class="keyfeature-card mb-10" elevation="12">
          <v-img :src="keyfeatureImages" height="200px" class="rounded-t-lg" />
          <v-card-title class="text-h6 font-weight-bold">Vehicle Valuation Made Simple</v-card-title>
          <v-card-text>
            Get instant valuations with CAP Clean, CAP Average, Below Market, Auction Prices, and Autoboli’s Predicted
            Value.
          </v-card-text>
        </v-card>

        <v-card class="keyfeature-card mb-10" elevation="12">
          <v-img :src="keyfeatureImages" height="200px" class="rounded-t-lg" />
          <v-card-title class="text-h6 font-weight-bold">Reauction Tracker</v-card-title>
          <v-card-text>
            Spot vehicles that didn’t sell earlier but are back again. Learn why they returned and decide if they’re
            worth bidding on now.
          </v-card-text>
        </v-card>

        <v-card class="keyfeature-card mb-10" elevation="12">
          <v-img :src="keyfeatureImages" height="200px" class="rounded-t-lg" />
          <v-card-title class="text-h6 font-weight-bold">Compare Auctions</v-card-title>
          <v-card-text>
            Side-by-side comparisons of prices, results, and trends across auction houses to find the best
            opportunities.
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import keyfeatureImages from '@/assets/images/tabs/keyfeature.jpg'

export default {
  name: 'KeyFeaturesSection',
  data() {
    return {
      keyfeatureImages
    }
  }
}
</script>

<style scoped>
.keyfeatures-wrapper {
  max-width: 1400px;
  background-color: aqua;
  position: relative;
}

/* LEFT CARDS slightly lower */
.left-cards v-card:nth-child(1) {
  margin-top: 80px;
}

.left-cards v-card:nth-child(2) {
  margin-top: 30px;
}

.left-cards v-card:nth-child(3) {
  margin-top: 0px;
}

/* RIGHT CARDS slightly higher */
.right-cards v-card:nth-child(1) {
  margin-top: 0px;
}

.right-cards v-card:nth-child(2) {
  margin-top: 30px;
}

.right-cards v-card:nth-child(3) {
  margin-top: 60px;
}

.keyfeature-card {
  width: 520px;
  border-radius: 16px;
  overflow: hidden;
}

@media (max-width: 960px) {

  .left-cards,
  .right-cards {
    align-items: center !important;
  }

  .left-cards v-card,
  .right-cards v-card {
    margin-top: 20px !important;
  }

  .keyfeature-card {
    width: 90% !important;
  }
}
</style>
