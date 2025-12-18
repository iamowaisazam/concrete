<template>
  <v-card
    :loading="loading"
    :disabled="loading"
    title="Stock Adjustment Information"
    subtitle="Create New Stock Adjustment Item"
  >
    <v-card-text>
      <v-row class="pt-3" dense>
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
import StockAdjustment from "@/models/stockadjustment.model";
import ProductDropdown from "@/components/productDropdown.vue";
export default {
  components: {
    ProductDropdown,
    },
  data() {
    return {
      loading: false,
      form: {
        date: '',
        product_id: '',
        qty: '',
        type: '',
        price: '',
        remarks: '',
      },
    }
  },
  computed: {
    imagePreview() {
      if (!this.form.image) return null;
      return URL.createObjectURL(this.form.image);
    }
  },
  mounted() {
    this.getSingleRecord();
  },
  methods: {
    async submitForm() {
        this.loading = true;

        try {
            let formData = new FormData();
            formData.append('date', this.form.date);
            formData.append('product_id', this.form.product_id);
            formData.append('qty', this.form.qty);
            formData.append('price', this.form.price);
            formData.append('remarks', this.form.remarks);
            formData.append('type', this.form.type);
            
            let res = await StockAdjustment.create(formData);
            this.$alertStore.add(res.message, 'success');
            this.$router.push('/user/stockadjustment');

        } catch (error) {
            console.error(error);
            this.$alertStore.add(error.message, 'error');
        } finally {
            this.loading = false;
            this.resetForm();
        }
    },

    async getSingleRecord() {
    this.loading = true;
    try {
      const id = this.$route.params.id;   // URL se id
      const res = await StockAdjustment.find(id);

      // form me data fill
      this.form.date = res.data.date;
      this.form.product_id = res.data.product_id;
      this.form.qty = res.data.qty;
      this.form.type = res.data.type;
      this.form.price = res.data.price;
      this.form.remarks = res.data.remarks;

    } catch (error) {
      console.error(error);
      this.$alertStore.add("Record load nahi hua", "error");
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
.form-label {
  font-weight: 500;
  margin-bottom: 4px;
  display: block;
}
</style>
