<template>
  <v-row>
    <v-col cols="12" sm="3">
      <label class="form-label">Status</label>
      <v-select
        v-model="form.status"
        :items="['Pending','Approve ']"
      />
    </v-col>

    <v-col cols="12" sm="3">
      <label class="form-label">Is Paid</label>
      <v-select
        v-model="form.is_paid"
        :items="[
          { text: 'Yes', value: 1 },
          { text: 'No', value: 0 }
        ]"
        item-title="text"
        item-value="value"
        placeholder="Select"
      />
    </v-col>



    <v-col cols="12" sm="3">
      <label class="form-label">Discount</label>
      <v-text-field v-model="form.discount" type="number"/>
    </v-col>

    <v-col cols="12" sm="3">
      <label class="form-label">Tax</label>
      <v-text-field v-model="form.tax" type="number"/>
    </v-col>
  </v-row>
</template>

<script setup>
defineProps({ form: Object })
</script>
