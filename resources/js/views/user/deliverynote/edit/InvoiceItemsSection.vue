<template>
  <v-row
    v-for="(item, i) in items"
    :key="i"
    class="mt-2 align-center"
    dense
  >
    <v-col cols="12" md="3">
      <productDropDown
        v-model="item.product_id"
        label="Product"
      />
    </v-col>
    <v-col cols="6" md="2">
      <v-text-field
        v-model.number="item.quantity"
        label="Qty"
        type="number"
        density="compact"
      />
    </v-col>
    <v-col cols="6" md="3">
      <v-text-field
        v-model.number="item.price"
        label="Price"
        type="number"
        density="compact"
      />
    </v-col>
    <!-- <v-col cols="6" md="2">
      <v-text-field
        v-model.number="item.discount"
        label="Discount"
        type="number"
        density="compact"
      />
    </v-col>
    <v-col cols="6" md="2">
      <v-text-field
        v-model.number="item.tax"
        label="Tax"
        type="number"
        density="compact"
      />
    </v-col> -->
    <v-col cols="6" md="3">
      <v-text-field
        :model-value="itemTotal(item)"
        label="Total"
        density="compact"
        disabled
      />
    </v-col>
    <v-col cols="6" md="1" class="text-center">
      <v-btn
        color="danger"

        @click="$emit('remove', i)"
      >X</v-btn>
    </v-col>

  </v-row>
  <div class="mt-4 text-center">
    <v-btn
      color="primary"
      variant="tonal"
      icon="mdi-plus"
      @click="$emit('add')"
    />
  </div>
</template>

<script setup>
import productDropDown from "@components/productDropdown.vue";

defineProps({
  items: {
    type: Array,
    required: true,
  },
});

defineEmits(["add", "remove"]);

const itemTotal = (item) => {
  const qty = Number(item.quantity || 0);
  const price = Number(item.price || 0);
  const discount = Number(item.discount || 0);
  const tax = Number(item.tax || 0);

  return (qty * price - discount + tax).toFixed(2);
};
</script>
