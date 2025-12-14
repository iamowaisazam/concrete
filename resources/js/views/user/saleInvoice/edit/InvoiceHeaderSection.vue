<template>
  <v-row class="pt-3">
    <v-col cols="12" sm="3">
      <label class="form-label">Date</label>
      <v-text-field v-model="form.date" type="date"/>
    </v-col>

    <v-col cols="12" sm="3">
      <label class="form-label">Due Date</label>
      <v-text-field v-model="form.due_date" type="date"/>
    </v-col>

    <v-col cols="12" sm="3">
      <label class="form-label">Reference</label>
      <v-text-field v-model="form.ref"/>
    </v-col>

    <v-col cols="12" sm="3">
      <label class="form-label">Remarks</label>
      <v-text-field v-model="form.remarks"/>
    </v-col>
  </v-row>
</template>

<script setup>
defineProps({ form: Object })
</script>
