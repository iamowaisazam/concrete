<template>
  <v-row>
    <v-col cols="12" sm="6">
      <label class="form-label">Status</label>
      <v-select
        v-model="form.status"
        :items="['pending','paid','partial']"
      />
    </v-col>

    <v-col cols="12" sm="6">
      <v-checkbox v-model="form.is_paid" label="Is Paid"/>
    </v-col>

    <v-col cols="12" sm="6">
      <label class="form-label">Discount</label>
      <v-text-field v-model="form.discount" type="number"/>
    </v-col>

    <v-col cols="12" sm="6">
      <label class="form-label">Tax</label>
      <v-text-field v-model="form.tax" type="number"/>
    </v-col>
  </v-row>
</template>

<script setup>
defineProps({ form: Object })
</script>
