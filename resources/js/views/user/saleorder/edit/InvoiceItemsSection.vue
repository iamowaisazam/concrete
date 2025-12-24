<template>
 


    <v-row v-for="(item,i) in items" :key="i" class="mt-2">
      <v-col cols="3">
          <productDropDown
                v-model="item.product_id"
                label="Product"
            />
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

    <div class="mt-4 text-center" > 
          <v-btn color="primary" variant="tonal" icon="mdi-plus" @click="$emit('add')"></v-btn>
    </div>
    
  
</template>

<script setup>
import productDropDown from "@components/productDropdown.vue" 
defineProps({ items: Array })
defineEmits(['add','remove'])
</script>
