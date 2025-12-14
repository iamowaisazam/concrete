<template>
  <v-card :loading="loading" :disabled="loading"
          title="Sale Invoice Information"
          subtitle="Edit Sale Invoice">

    <v-card-text>

      <div class="section">
        <h4 class="section-title">Invoice Details</h4>
        <v-divider class="my-3"/>
        <InvoiceHeaderSection :form="form"/>

        <InvoiceStatusSection :form="form"/>
      </div>

      <div class="section">
        <h4 class="section-title">Invoice Items</h4>
        <v-divider class="my-3"/>
        <InvoiceItemsSection
          :items="form.items"
          @add="addItem"
          @remove="removeItem"
        />
      </div>

    </v-card-text>

    <v-card-actions>
      <v-btn color="primary" @click="submitForm">Update</v-btn>
      <v-btn color="danger" @click="loadInvoice">Cancel</v-btn>
    </v-card-actions>

  </v-card>
</template>


<script>
import InvoiceHeaderSection from "./InvoiceHeaderSection.vue";
import InvoiceStatusSection from "./InvoiceStatusSection.vue";
import InvoiceItemsSection from "./InvoiceItemsSection.vue";
import saleInvoiceModel from "@/models/saleInvoice.model";

export default {
  components: {
    InvoiceHeaderSection,
    InvoiceStatusSection,
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
