<template>
  <v-select
    v-bind="$attrs"
    :model-value="modelValue"
    :items="data"
    item-title="firstName"
    item-value="id"
    :loading="loading"
    clearable
    @update:model-value="emitValue"
  />
</template>

<script>
import UserModel from "@/models/user.model";

export default {
  name: "UserDropdown",

  props: {
    modelValue: {
      type: Number, // ✅ ONLY NUMBER
      default: null,
    },
  },

  emits: ["update:modelValue"],

  data() {
    return {
      data: [],
      loading: false,
    };
  },

  mounted() {
    this.getData();
  },

  methods: {
    async getData() {
      this.loading = true;
      try {
        const res = await UserModel.all({ length: 1000 });
        this.data = res.data ?? [];
      } catch (e) {
        console.error(e);
        this.data = [];
      } finally {
        this.loading = false;
      }
    },

    emitValue(val) {
      // ✅ force number
      this.$emit("update:modelValue", val ? Number(val) : null);
    },
  },
};
</script>
