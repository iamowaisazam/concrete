<template>
    <v-container class="bg-surface" fluid>
        <!-- Header Section -->
        <div class="text-center justify-center py-12 " style="margin-top: 100px;"> <v-chip class="mb-4" small> Monthly •
                Yearly <span class="text-subtitle-2 ml-2 text-primary">Up to 20% OFF</span> </v-chip>
            <h1 class="text-h3 font-weight-bold white--text mb-3"> Flexible plans for AI content creators </h1>
            <p class="text-body-1 white--text opacity-80"> Choose the best plan for your needs. </p>
            <!-- Billing Toggle -->
            
        </div>
        <v-row justify="center " no-gutters>
            <v-col v-for="plan in pricingPlains" :key="plan.title" cols="12" sm="6" md="3" lg="2" >
                <!-- Most Popular Chip -->
                <v-chip v-if="plan.mostPopular" class="font-weight-bold bg-primary text-white rounded-sm"
                    style="position: absolute; margin-left: 90px; margin-top: -15px; z-index: 1;">
                    Most popular
                </v-chip>

                <!-- Card -->
                <v-card :elevation="plan.mostPopular ? 12 : 8" class="h-100 d-flex flex-column border-md pa-4" :style="{
                    backgroundColor: ' #0f1c2c',
                    minHeight: plan.minHeight
                }">
                    <div style="min-height: 150px;" class="text-center">
                        <v-card-title class="text-h6 font-weight-bold py-6">
                            {{ plan.title }}
                            <div class="text-h4 font-weight-bold mb-1 mt-2">
                                £{{ plan.price }} <small class="text-body-2">/month</small>
                            </div>
                        </v-card-title>

                        <v-btn to="/checkout" color="primary" class="text-capitalize" width="200px">
                            Get Started
                        </v-btn>
                    </div>

                    <v-card-text class="text-start flex-grow-1">
                        <v-divider class="my-6"></v-divider>

                        <ul class="text-left pa-0" style="list-style: none;">
                            <li v-for="(feature, index) in plan.features" :key="index" class="mb-3 d-flex">
                                <v-icon small color="primary" class="mr-2">mdi-check</v-icon>
                                {{ feature }}
                            </li>
                        </ul>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>


</template>

<script>

import pricingPlains from "@/json/monthlypricingplain.json";
export default {
    data() {
        return {
            isYearly: false,
            pricingPlains,
        }
    }
}

</script>
