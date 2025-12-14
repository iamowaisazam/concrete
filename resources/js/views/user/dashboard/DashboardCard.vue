<template>
  <v-card variant="elevated" elevation="5" color="background" class="border-bottom w-100">
    <v-container>
      <div class="d-flex h-6 align-center ">
        <span class="text-h4 px-1">{{ count }}</span>
      </div>
      <div class="pt-3 text-body-1 text-light ">{{ title }}</div>
    </v-container>
  </v-card>
</template>

<script>
export default {
  name: 'DashboardCard',
  props: {
    title: String,
    count: Number,
  },
};
</script>

<style scoped>
.border-bottom {
  border-bottom: 5px solid rgb(var(--v-theme-primary)) !important;
}
</style>    