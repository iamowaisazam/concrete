<template>
  <v-card
    :loading="loading"
    :disabled="loading"
    title="Expense Category Information"
    subtitle="Create New Expense Category Item"
  >
    <v-card-text>
      <v-row class="pt-3">

        <!-- Date -->
        <v-col cols="12" sm="6">
          <label class="form-label">Date</label>
          <v-text-field
            v-model="form.date"
            type="date"
            height="38px"
          />
        </v-col>

        <!-- Ref -->
        <v-col cols="12" sm="6">
          <label class="form-label">Reference</label>
          <v-text-field
            v-model="form.ref"
            height="38px"
            placeholder="Enter reference"
          />
        </v-col>

      </v-row>
    </v-card-text>

    <v-card-actions>
      <v-btn color="primary" variant="flat" @click="submitForm">Submit</v-btn>
      <v-btn color="danger" variant="flat" @click="resetForm">Cancel</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import saleInvoiceModel from "@/models/saleInvoice.model";

export default {
  data() {
    return {
      loading: false,
      form: {
        date: '',
        ref: '',
      },
    }
  },
  methods: {
    async submitForm() {
      this.loading = true;
      try {
        const formData = new FormData();
        Object.keys(this.form).forEach(key => {
          formData.append(key, this.form[key]);
        });

        const res = await saleInvoiceModel.create(formData);

  
        this.$alertStore.add(res.message || "Record created", 'success');


        if (res.data && res.data.id) {
          this.$router.push(`/user/saleInvoice/edit/${res.data.id}`);
        }

      } catch (error) {
        console.error(error);
        this.$alertStore.add(error.message || 'Create failed', 'error');
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.form = {
        date: '',
        ref: '',
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
