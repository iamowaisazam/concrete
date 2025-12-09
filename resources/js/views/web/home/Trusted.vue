<template>
    <div class="trusted-section py-16">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-h4 font-weight-bold mb-4">Trusted By Dealers & Traders</h2>
            <p class="text-body-1 text-grey-darken-2 max-w-800 mx-auto px-4">
                Autoboli is built for professionals who value time and data accuracy.
                Our platform handles thousands of listings daily, ensuring you never miss a deal.
            </p>
        </div>

        <!-- Stats Cards -->
        <v-container max-width="1600px" class="">
            <v-row justify="center" class="" no-gutters>
                <!-- Card 1 - Blue -->
                <v-col cols="12" sm="6" md="4" lg="3" class="d-flex justify-center">
                    <v-card rounded="lg" elevation="12" class="text-white pa-8 mt-8 ml-4  blue-card" color="primary"
                        style="height: 350px;">
                        <div class="text-h1 font-weight-black mb-4">123+</div>
                        <div class="text-h6 font-weight-bold " style="margin-top: 120px;">Projects Completed</div>
                        <p class="text-body-2 opacity-90">
                            Lorem ipsum dolor sit amet, cons ectetur, luctus nec
                        </p>
                    </v-card>
                </v-col>

                <!-- Card 2 - White -->
                <v-col cols="12" sm="6" md="4" lg="3" class="d-flex justify-center">
                    <v-card rounded="xl" elevation="12" class="pa-8 ml-4   text-start white-card  " color="white"
                        style="height: 350px;  border: 1px solid #000;">
                        <div class="text-h1 font-weight-black mb-4  " border="md">75+</div>
                        <div class="text-h6 font-weight-bold mb-3" style="margin-top: 120px;">Strong Client
                            Relationships</div>
                        <p class="text-body-2 text-grey-darken-2">
                            Lorem ipsum dolor sit amet, cons ectetur, luctus nec
                        </p>
                    </v-card>
                </v-col>

                <!-- Card 3 - Blue -->
                <v-col cols="12" sm="6" md="4" lg="3" class="d-flex justify-center">
                    <v-card rounded="lg" elevation="12" class="text-white pa-8 ml-4 mt-8 text-start blue-card"
                        color="primary" style="height: 350px;">
                        <div class="text-h1 font-weight-black mb-4">155+</div>
                        <div class="text-h6 font-weight-bold" style="margin-top: 100px;">Expertise Across Multiple
                            Channels</div>
                        <p class="text-body-2 mt-2 opacity-90">
                            Lorem ipsum dolor sit amet, cons ectetur, luctus nec
                        </p>
                    </v-card>
                </v-col>

                <!-- Card 4 - White -->
                <v-col cols="12" sm="6" md="4" lg="3" class="d-flex justify-center">
                    <v-card rounded="xl" elevation="12" class="pa-8 ml-4  text-start white-card" color="white"
                        style="height: 350px; border: 1px solid #000;">
                        <div class="text-h1 font-weight-black  mb-4">120+</div>
                        <div class="text-h6 font-weight-bold mb-3" style="margin-top: 120px;">Outstanding Customer
                            Service</div>
                        <p class="text-body-2 text-grey-darken-2">
                            Lorem ipsum dolor sit amet, cons ectetur, luctus nec
                        </p>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    name: 'TrustedSection'
}
</script>

<style scoped>
.trusted-section {
    background: #fff;
}



.max-w-800 {
    max-width: 800px;
}

/* Use h1 instead of h2 for the huge numbers like in the screenshot */
.text-h1 {
    font-size: 4.5rem !important;
    line-height: 1;
}
</style>