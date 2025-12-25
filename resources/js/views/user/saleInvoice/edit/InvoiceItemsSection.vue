<template>
 


    <v-row v-for="(item,i) in items" :key="i" class="mt-2">
      <v-col cols="2">
          <DeliveryNoteDropDown
                v-model="item.delivery_note_id"
                label="Delivery Note"
            />
      </v-col>
      <v-col cols="1">
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
      <v-col cols="6" md="2">
      <v-text-field
        :model-value="itemTotal(item)"
        label="Total"
        density="compact"
        disabled
      />
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
import DeliveryNoteDropDown from "@components/DeliveryNoteDropdown.vue"
defineProps({ items: Array })
defineEmits(['add','remove'])
const itemTotal = (item) => {
  const qty = Number(item.quantity || 0);
  const price = Number(item.price || 0);
  const discount = Number(item.discount || 0);
  const tax = Number(item.tax || 0);

  return (qty * price - discount + tax).toFixed(2);
};
</script>
