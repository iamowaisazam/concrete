<template>
  <v-card :loading="loading" :disabled="loading" title="Stock Adjustment Information"
    subtitle="Edit Stock Adjustment Item">
    <v-card-text>
      <v-row class="pt-3">

        <!-- Date -->
        <v-col cols="12" md="4">
          <label class="form-label">Date</label>
          <v-text-field v-model="form.date" type="date" density="compact" />
        </v-col>

        <!-- Product -->
        <v-col cols="12" md="4">
          <label class="form-label">Product</label>
          <ProductDropdown v-model="form.product_id" clearable placeholder="Select Product" />
        </v-col>

        <!-- Qty -->
        <v-col cols="12" md="4">
          <label class="form-label">Quantity</label>
          <v-text-field v-model="form.qty" type="number" density="compact" />
        </v-col>

        <!-- Type -->
        <v-col cols="12" md="4">
          <label class="form-label">Type</label>
          <v-select v-model="form.type" :items="[
            { title: 'In', value: 'in' },
            { title: 'Out', value: 'out' }
          ]" density="compact" />
        </v-col>

        <!-- Price -->
        <v-col cols="12" md="4">
          <label class="form-label">Price</label>
          <v-text-field v-model="form.price" type="number" density="compact" />
        </v-col>

        <!-- Remarks -->
        <v-col cols="12" md="4">
          <label class="form-label">Remarks</label>
          <v-text-field v-model="form.remarks" density="compact" />
        </v-col>

      </v-row>
    </v-card-text>

    <div class="mt-3 text-center">
      <v-btn color="primary" @click="updateForm">
        Update
      </v-btn>
    </div>
  </v-card>
</template>


<script>

import ProductDropdown from "@/components/productDropdown.vue";
import generalModel from "@/models/general.model";

export default {
  components: {
    ProductDropdown
  },

  data() {
    return {
      loading: false,
      form: {
        date: "",
        product_id: null,
        qty: "",
        type: "",
        price: "",
        remarks: ""
      }
    };
  },

  mounted() {
    this.loadAdjustment();
  },

  methods: {
    async loadAdjustment() {
      this.loading = true;
      try {

        const id = this.$route.params.id;
        const res = await generalModel.get('/api/stockadjustment/' + id, {});
        this.date = res.date;
        this.product_id = res.product_id;
        this.qty = res.qty;
        this.type = res.type;
        this.price = res.price;
        this.remarks = res.remarks;
      } catch (e) {
        this.$alertStore.add("Failed to load data", "error");
      } finally {
        this.loading = false;
      }
    },

    async updateForm() {

      this.loading = true;

      try {

          const id = this.$route.params.id;
          let res = await generalModel.put('/api/stockadjustment/' + id, this.form);
          this.$alertStore.add(res.message, "success");
          this.$router.push("/user/stockadjustment");

      } catch (e) {
          this.$alertStore.add("Update failed", "error");
      } finally {
          this.loading = false;
      }

    }

  }
};
</script>


