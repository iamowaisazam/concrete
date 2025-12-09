<template>

    <v-card
    class="border bg-surface pricing-card rounded-xl pa-6 text-center"
    :elevation="2"
    height="100%"
    color="#1e1e2e"
    >
    <v-chip color="primary" class="mb-4 d-flex justify-center" small>
        Most Popular
    </v-chip>

    <h2 class="text-h4 font-weight-bold text-white mb-2">{{ item.title }}</h2>
    <p style="color:rgb(var(--v-theme-light));" class=" mb-6">{{ item.des }}</p>

    <div class="text-body-1 text-white font-weight-bold mb-8">
        <small>$</small>
        <span class="font-weight-bold text-body-1 text-primary">{{ item.price }}</span>
        <small class="">/month</small>
    </div>

    <div class="w-100 border" >

    </div>

    <v-list class="bg-transparent text-left" density="comfortable">
        <v-list-item v-for="n in 5" :key="n">
            <template v-slot:prepend>
                <v-icon color="primary" class="mr-3">mdi-check-circle</v-icon>
            </template>
            <v-list-item-title class="text-body-1 no-ellipsis" style="color:rgb(var(--v-theme-light));" >
                100 responses a month
            </v-list-item-title>
        </v-list-item>
    </v-list>

    <v-spacer></v-spacer>


    <v-btn v-if="item.id == 1"
        color="primary"
        variant="tonal"
        class="mt-8 text-success font-weight-bold text-capitalize">
        Current Plan</v-btn>
    
    <v-btn v-else
        color="primary"
        variant="tonal"
        class="mt-8 text-white font-weight-bold text-capitalize">
        Select Plan</v-btn>

    </v-card>

</template>

<script>
 export default {
    props: {
        item:{
            type:Object,
            default:{}
        }
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

    .no-ellipsis{
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: unset !important;
    }
</style>