<template>
  <v-select
    v-bind="$attrs"
    :model-value="modelValue"
    :items="data"
    item-title="title"
    :loading="loading"
    return-object
    @update:model-value="handleValue"
  />
</template>


<script>
import generaApi from "@/models/general.model"

export default {
  name: "DeliveryNoteDropdown",

  props: {
    modelValue: {
      type: Object,
      default: null
    },
    userId: {
      type: [Number, String],
      default: null
    }
  },

  data() {
    return {
      data: [],
      loading: false,
      url: "/api/deliveryNotes"
    }
  },

  watch: {
    userId: {
      immediate: true,
      handler() {
        this.getData()
      }
    }
  },

  methods: {
    async getData() {
      if (!this.userId) {
        this.data = []
        return
      }

      this.loading = true
      try {
        const res = await generaApi.all(this.url, {
          length: 1000,
          user_id: this.userId
        })

        this.data = res.data.map(item => ({
          id: item.id,
          title: `${item.ref} - ${item.id}`,
          total: Number(item.total || 0)
        }))

      } catch (e) {
        console.error("Delivery note load failed", e)
        this.data = []
      } finally {
        this.loading = false
      }
    },

    handleValue(val) {
      this.$emit("update:modelValue", val)
    }
  }
}
</script>


<style scoped>
    
</style>