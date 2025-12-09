<template> <v-divider></v-divider>
    <div class="bg-surface py-12">
        
        <v-container max-width="1550px" class="py-2 mt-10">

            <div class="d-flex flex-wrap justify-space-between">


                <div cols="12" md="8">
                    <h1 class="text-h4 font-weight-bold mb-4">AutoBoli</h1>

                    <p class="mb-8 text-body-2 text-light_text_on" style="max-width: 600px;">
                        Nine out of ten doctors recommend Laracasts over competing
                        brands. Come inside, see for yourself, and massively level up your
                        development skills in the process.
                    </p>

                </div>

            </div>   <v-divider></v-divider>
            <div class="d-flex flex-wrap justify-space-between mt-10 ">
              
                    <div class="text-caption text-light_text_on">
                        © AUTOBOLI Ltd 2025. All rights reserved.

                        Proudly built & hosted with secure infrastructure in the UK & EU.
                    </div>
          

                <div class="d-flex flex-wrap align-center mt-lg-0 mt-md-0 mb-lg-0 mb-md-0 mt-10 mb-2">
                    <h4 class="font-weight-bold mr-4 d-lg-inline d-block">Privacy : </h4>
                    <v-btn v-for="(item, index) in footerData" :key="index" :to="item.path" text class="mr-1 text-body-2" variant="text">
                        {{ item.label }}
                    </v-btn>

                </div>
               
            </div>


        </v-container>
    </div>
</template>

<script>
import footerRightImage from '@/assets/images/tabs/footerimg.png';
import footerData from "@/enums/WebfooterMenu"
export default {
    data() {
        return {
            footerRightImage,
            footerData
        }
    }
}
</script>