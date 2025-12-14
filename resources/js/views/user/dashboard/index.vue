<template>
  <v-container fluid>
    <v-row>
      <!-- Dashboard Cards -->
      <v-col cols="12" sm="6" md="3" v-for="(value, key) in counter" :key="key">
        <dashboard-card :title="value.title" :count="value.count" />
      </v-col>
    </v-row>

    <!-- Graph Card -->
    <v-row>
      <v-col cols="12" md="12">
        <v-card variant="elevated" elevation="5" color="background">
          <v-container>
            <h2>Sales Overview</h2>
            <line-chart :chart-data="chartData" />
          </v-container>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import api from '@/plugins/axios';
import DashboardCard from './DashboardCard.vue';
import LineChart from './LineChart.vue';

export default {
  name: 'AuctionDashboard',
  components: {
    DashboardCard,
    LineChart,
  },
  data() {
    return {
      counter: {
        customers: {
          title: 'Customers',
          count: 100,
        },
        products: {
          title: 'Inventory',
          count: 100,
        },
        invoices: {
          title: 'Expense',
          count: 100,
        },
        category: {
          title: 'Category',
          count: 100,
        },
      },
      chartData: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [
          {
            label: 'Sales',
            data: [100, 200, 300, 400, 500, 600],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
          },
        ],
      },
    };
  },
};
</script>