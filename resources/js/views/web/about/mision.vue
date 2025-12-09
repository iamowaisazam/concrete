<!-- MissionSection.vue -->
<template>
    <section class="bg-surface ">
        <v-container fluid max-width="1400px" class="px-0 py-16 py-md-20">
            <v-row no-gutters="" align="center">

                <!-- LEFT: Text Content -->
                <v-col cols="12" lg="6">
                    <div class="pl-0 pl-md-8">
                        <h2 class="text-h3  text-white mb-8">
                            {{ data.title }}
                        </h2>

                        <div class="">


                            <div style="border-left: 6px solid white;">
                                <p class="text-body-1 text-grey-lighten-1 mb-10 opacity-90 ml-4 ">
                                    {{ data.highlight }} </p>
                            </div>


                            <p class="text-body-1 text-grey-lighten-1 mb-10 mr-10 opacity-90 ">
                                {{ data.description }}
                            </p>

                            <v-btn variant="tonal" size="large" class="px-8 text-capitalize bg-white">
                                {{ data.buttonText }}
                            </v-btn>
                        </div>
                    </div>
                </v-col>


                <v-col cols="12" lg="6">

                    <img :src="rightImage" alt="" class="missionImage mt-10">

                </v-col>

            </v-row>
        </v-container>
    </section>
</template>

<script>
import missionData from '@/json/mision.json'
import rightImage from '@/assets/images/tabs/missionleft.png'
export default {
    name: 'MissionSection',
    data() {
        return {
            data: missionData,
            rightImage
        }
    }
}
</script>


<style scoped>
/* Float animations can be kept if needed */
@media (max-width: 960px) {

    /* Big White Card */

}

@media (max-width : 600px) {

    .missionImage {
        width: 300px;
    }

}
</style>
