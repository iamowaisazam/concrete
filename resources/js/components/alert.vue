<template>
  <v-snackbar v-model="alert.show" :color="alert.current?.color || 'primary'" location="top right" rounded="lg"
    variant="elevated" elevation="6" multi-line>
    <v-row align="center" justify="space-between" no-gutters class="px-4">
      <v-col class="d-flex align-center">
        <span class="font-medium">{{ alert.current?.message }}</span>
      </v-col>

      <v-col class="d-flex justify-end" cols="auto">
        <v-btn icon variant="text" size="small" @click="alert.show = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-col>
    </v-row>
  </v-snackbar>
</template>

<script setup>
import { useAlertStore } from '@/stores/alertStore'
const alert = useAlertStore()
</script>
