<template>
  <v-row v-for="(item,i) in items" :key="i" class="mt-2">

    <v-col cols="3">
      <DeliveryNoteDropDown
        :model-value="item.delivery_note"
        :user-id="userId"
        label="Delivery Note"
        @update:modelValue="val => onDNChange(val, item)"
      />
    </v-col>

    <v-col cols="2">
      <v-text-field
        :model-value="deliveryNoteTotal(item)"
        label="DN Total"
        density="compact"
        disabled
      />
    </v-col>

    <v-col cols="2">
      <v-text-field v-model="item.discount" label="Discount"/>
    </v-col>

    <v-col cols="2">
      <v-text-field v-model="item.tax" label="Tax"/>
    </v-col>

    <v-col cols="2">
      <v-text-field
        :model-value="finalTotal(item)"
        label="Total"
        density="compact"
        disabled
      />
    </v-col>

    <v-col cols="1">
      <v-btn color="danger" @click="$emit('remove', i)">X</v-btn>
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
import DeliveryNoteDropDown from "@components/DeliveryNoteDropdown.vue"

defineProps({
  items: Array,
  userId: [Number, String]
})
const onDNChange = (val, item) => {
  item.delivery_note = val          // full object
  item.delivery_note_id = val?.id   // 👈 IMPORTANT
}
defineEmits(['add','remove'])

const deliveryNoteTotal = (item) =>
  Number(item.delivery_note?.total || 0).toFixed(2)

const finalTotal = (item) => {
  const dnTotal = Number(item.delivery_note?.total || 0)
  const discount = Number(item.discount || 0)
  const tax = Number(item.tax || 0)

  return (dnTotal - discount + tax).toFixed(2)
}
</script>
