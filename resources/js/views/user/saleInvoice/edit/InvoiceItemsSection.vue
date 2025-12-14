<template>
  <v-col cols="12">
    <v-btn color="success" @click="$emit('add')">Add Item</v-btn>

    <v-row v-for="(item,i) in items" :key="i" class="mt-2">
      <v-col cols="3">
        <v-text-field v-model="item.product_id" label="Product"/>
      </v-col>
      <v-col cols="2">
        <v-text-field v-model="item.quantity" label="Qty"/>
      </v-col>
      <v-col cols="2">
        <v-text-field v-model="item.price" label="Price"/>
      </v-col>
      <v-col cols="2">
        <v-text-field v-model="item.discount" label="Discount"/>
      </v-col>
      <v-col cols="2">
        <v-text-field v-model="item.tax" label="Tax"/>
      </v-col>
      <v-col cols="1">
        <v-btn color="danger" @click="$emit('remove', i)">X</v-btn>
      </v-col>
    </v-row>
  </v-col>
</template>

<script setup>
defineProps({ items: Array })
defineEmits(['add','remove'])
</script>
