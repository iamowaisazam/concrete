<template>

  <v-container>

    <v-card 
      :loading="loading" 
      :disabled="loading" 
      title="Sale Invoice Information" 
      subtitle="Edit Sale Invoice">
      <v-card-text>
          <v-row class="pt-3">
            <v-col cols="12" sm="4">
              <label class="form-label">Reference</label>
              <v-text-field v-model="form.ref" />
            </v-col>
            <v-col cols="12" sm="4">
              <label class="form-label">Date</label>
              <v-text-field v-model="form.date" type="date" />
            </v-col>
            <v-col cols="12" sm="4">
              <label class="form-label">Due Date</label>
              <v-text-field v-model="form.due_date" type="date" />
            </v-col>
            
            <v-col cols="12" sm="4">
              <label class="form-label">Remarks</label>
              <v-text-field v-model="form.remarks" />
            </v-col>
            <v-col cols="12" sm="4">
              <label class="form-label">Status</label>
              <v-select v-model="form.status" :items="['Pending', 'Approve ']" />
            </v-col>
            <v-col cols="12" sm="4">
              <label class="form-label">Is Paid</label>
              <v-select v-model="form.is_paid" :items="[
                { text: 'Yes', value: 1 },
                { text: 'No', value: 0 }
              ]" item-title="text" item-value="value" placeholder="Select" />
            </v-col>
            <!-- <v-col cols="12" sm="4">
              <label class="form-label">Discount</label>
              <v-text-field v-model="form.discount" type="number" />
            </v-col> -->
            <!-- <v-col cols="12" sm="4">
              <label class="form-label">Tax</label>
              <v-text-field v-model="form.tax" type="number" />
            </v-col> -->
          </v-row>
      </v-card-text>
    </v-card>
    <v-card :loading="loading" :disabled="loading" class="mt-3">
      <v-card-text>
        <InvoiceItemsSection :items="form.items" @add="addItem" @remove="removeItem" />
      </v-card-text>
    </v-card>
    <v-card :loading="loading" :disabled="loading" class="mt-3" title="Invoice Total">
      <v-card-text>
        <v-row class="mb-2">
            <v-col  cols="12" sm="3" >
                <label class="form-label">Subtotal</label>
                <v-text-field disabled="true" :model-value="0" />
            </v-col>
            <v-col cols="6" sm="3" >
                <label class="form-label">Discount</label>
                <v-text-field  v-model="form.discount" />
            </v-col>
            <v-col cols="6" sm="3" >
              <label class="form-label">Tax</label>
                <v-text-field  v-model="form.tax" />
            </v-col>
            <v-col cols="6" sm="3" >
              <label class="form-label">Grand Total</label>
                <v-text-field disabled="true" :model-value="grandTotal" />
            </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <div class="mt-3 text-center" >
        <v-btn color="primary" @click="submitForm">Save</v-btn>
    
    </div>

  </v-container>

</template>


<script>
import InvoiceItemsSection from "./InvoiceItemsSection.vue";
import saleInvoiceModel from "@/models/saleInvoice.model";

export default {
  components: {
    InvoiceItemsSection
  },

  data() {
    return {
      loading: false,
      form: {
        date: "",
        due_date: "",
        ref: "",
        remarks: "",
        status: "pending",
        is_paid: 0,
        discount: 0,
        tax: 0,
        user_id: 1,
        items: []
      }
    };
  },

  mounted() {
    this.loadInvoice();
  },

  methods: {
    async loadInvoice() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        const res = await saleInvoiceModel.find(id);
        Object.assign(this.form, res.data);
      } finally {
        this.loading = false;
      }
    },

    addItem() {
      this.form.items.push({
        product_id: "",
        quantity: 1,
        price: 0,
        discount: 0,
        tax: 0
      });
    },

    removeItem(index) {
      this.form.items.splice(index, 1);
    },

    async submitForm() {
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append("_method", "put");

        // ===== invoice fields =====
        const fields = [
          "date",
          "due_date",
          "ref",
          "remarks",
          "status",
          "discount",
          "tax",
        ];

        fields.forEach(f => {
          fd.append(f, this.form[f] ?? "");
        });

        fd.append("is_paid", this.form.is_paid ? 1 : 0);

        // ✅ user_id ONLY for invoice
        fd.append("user_id", 1);

        // ===== invoice items =====
        this.form.items.forEach((item, i) => {
          if (!item.product_id) return; // safety

          fd.append(`items[${i}][product_id]`, item.product_id);
          fd.append(`items[${i}][quantity]`, item.quantity ?? 1);
          fd.append(`items[${i}][price]`, item.price ?? 0);
          fd.append(`items[${i}][discount]`, item.discount ?? 0);
          fd.append(`items[${i}][tax]`, item.tax ?? 0);
        });

        await saleInvoiceModel.update(this.$route.params.id, fd);
        this.$router.push("/user/saleinvoice");

      } catch (e) {
        console.error(e);
        this.$alertStore.add("Invoice update failed", "error");
      } finally {
        this.loading = false;
      }
    },




  }
};
</script>
<style>
.section {
  margin-bottom: 28px;
}

.section-title {
  font-size: 16px;
  font-weight: 600;
}
</style>
