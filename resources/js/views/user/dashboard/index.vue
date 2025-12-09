<template>
  <!-- <v-container fluid >
    <v-row class="">
      <v-col cols="12" sm="6" md="3" class="" v-for="(value,key) in counter" >
        <v-card variant="elevated" elevation="5" color="background" class="border-bottom w-100">
          <v-container>
            <div class="d-flex h-6 align-center ">
              <span class="text-h4 px-1">{{ value.count}}</span>
            </div>
            <div class="pt-3 text-body-1 text-light ">{{ value.title}}</div>
          </v-container>
        </v-card>
      </v-col>
    </v-row>
</v-container> -->
</template>

<script>
import api from '@/plugins/axios';

export default {
  name: 'AuctionDashboard',

  data() {
    return {
      counter: {
        customers:{
          title:'Customers',
          count:100,
        },
        products:{
          title:'Products',
          count:100,
        },
        invoices:{
          title:'Sale Invoice',
          count:100,
        },
      },
    }
  },
  computed: {
    

  },
  methods: {

   
  },
  mounted() {
   
    
  }

  
}

</script>

<style scoped>





  .border-bottom {
    border-bottom: 5px solid rgb(var(--v-theme-primary)) !important;
  }
</style>