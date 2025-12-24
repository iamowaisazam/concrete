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
              <label class="form-label">Remarks</label>
              <v-text-field v-model="form.remarks" />
            </v-col>
            <v-col cols="12" sm="4">
              <label class="form-label">Status</label>
              <v-select v-model="form.status" :items="['Pending', 'Approve ']" />
            </v-col>
            <v-col cols="3">
              <!-- <UserDropdown
                    v-model="item.user_id"
                    label="Product"
                /> -->
            </v-col>

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
                <v-text-field disabled="true" :model-value="subtotal" />
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
import InvoiceItemsSection from "./edit/InvoiceItemsSection.vue";
import saleInvoiceModel from "@/models/saleInvoice.model";
import UserDropdown from "@/components/UserDropdown.vue"
export default {
  components: {
    InvoiceItemsSection,
    UserDropdown
  },

  data() {
    return {
      loading: false,
      form: {
        date: "",
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


  methods: {


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




  },
  computed: {
    subtotal() {
      return this.form.items.reduce((sum, item) => {
        const qty = Number(item.quantity || 0);
        const price = Number(item.price || 0);
        const discount = Number(item.discount || 0);
        const tax = Number(item.tax || 0);

        const itemBase = qty * price;
        const itemTotal = itemBase - discount + tax;

        return sum + itemTotal;
      }, 0);
    },
    invoiceDiscountAmount() {
      const discountPercent = Number(this.form.discount || 0);
      return (this.subtotal * discountPercent) / 100;
    },

    invoiceTaxAmount() {
      const taxPercent = Number(this.form.tax || 0);
      return ((this.subtotal - this.invoiceDiscountAmount) * taxPercent) / 100;
    },

    grandTotal() {
      return (
        this.subtotal -
        this.invoiceDiscountAmount +
        this.invoiceTaxAmount
      ).toFixed(2);
    }

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
