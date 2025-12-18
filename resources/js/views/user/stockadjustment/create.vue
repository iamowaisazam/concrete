<template>
  <v-card
    :loading="loading"
    :disabled="loading"
    title="Stock Adjustment Information"
    subtitle="Create New Stock Adjustment Item"
  >
    <v-card-text>
      <v-row class="pt-3" >
        <v-col cols="12" md="4">
          <label class="form-label">Date</label>
          <v-text-field
            v-model="form.date"
            type="date"
            density="compact"
          />
        </v-col>

        <v-col cols="12" sm="4">
          <label class="form-label">Product</label>
          <ProductDropdown 
            v-model="form.product_id"
            clearable  
            placeholder="Select Product" />
        </v-col>
        <v-col cols="12" md="4">
          <label class="form-label">Quantity</label>
          <v-text-field
            v-model="form.qty"
            type="number"
            density="compact"
            placeholder="Enter qty"
          />
        </v-col>
        <v-col cols="12" md="4">
          <label class="form-label">Type</label>
          <v-select
            v-model="form.type"
            :items="[
              { title: 'In', value: 'in' },
              { title: 'Out', value: 'out' }
            ]"
            density="compact"
            placeholder="Select type"
          />
        </v-col>
        <v-col cols="12" md="4">
          <label class="form-label">Price</label>
          <v-text-field
            v-model="form.price"
            type="number"
            density="compact"
            placeholder="Enter price"
          />
        </v-col>
        <v-col cols="12" md="4">
          <label class="form-label">Remarks</label>
          <v-text-field
            v-model="form.remarks"
            density="compact"
            placeholder="Optional remarks"
          />
        </v-col>

      </v-row>
    </v-card-text>

    <div class="mt-3 text-center">
      <v-btn color="primary" @click="submitForm">
        Submit
      </v-btn>
    </div>
  </v-card>
</template>


<script>

import ProductDropdown from "@/components/productDropdown.vue";
import GeneralModel from "@/models/general.model";
export default {
  components: {
    ProductDropdown,
    },
  data() {
    return {
      loading: false,
      form: {
        date: '',
        product_id: null,
        qty: '',
        type: '',
        price: '',
        remarks: '',
      },
    }
  },
  computed: {
   
  },
  mounted() {
  
  },
  methods: {
    async submitForm() {
        this.loading = true;

        try {
          
            let res = await  GeneralModel.post("/api/stockadjustment",this.form);
            this.$alertStore.add(res.message, 'success');
            this.$router.push('/user/stockadjustment');

        } catch (error) {
            console.error(error);
            this.$alertStore.add(error.message, 'error');
        } finally {
            this.loading = false;
          
        }

    },


    resetForm() {
      this.form = {
        title: '',
      };
    }
  }
}
</script>

<style scoped>

</style>
