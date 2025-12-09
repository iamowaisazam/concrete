<template>
   
    <v-card title="Pricing Plans" >
        <div class="border" ></div>
        <v-container fluid class="pa-8 pa-md-16" max-height="700px">
            <v-row justify="center" class="gap-6">
                <v-col v-for="item in price" cols="12" sm="6" md="3">
                <PriceCard :item="item" />
                </v-col>   
            </v-row>
        </v-container>
  </v-card>
</template>

<script>
import PriceCard from './PriceCard.vue';


 export default {
    components: {
        PriceCard
    },
    data() {
        return {
            price:[
                {
                    id:1,
                    title:'Free',
                    des:'For small dealers.',
                    price:'0.00',
                },
                {
                    id:2,
                    title:'Ulta',
                    des:'For medium-sized businesses.',
                    price:'100.00',
                },
                {
                    id:3,
                    title:'Plus',
                    des:'For larger operations.',
                    price:'50.00',
                },
                {
                    id:4,
                    title:'Entry',
                    des:'For small dealers.',
                    price:'30.00',
                }
            ],
        };
    },
}

</script>

<style scoped>
    .pricing-card {
    display: flex;
    flex-direction: column;
    }
    .v-application {
    background: #0f0f1e !important;
    }
</style>