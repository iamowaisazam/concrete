<template>
  <v-container>
    <v-card
      :loading="loading"
      :disabled="loading"
    >
      <v-card-title>Edit Sale Order</v-card-title>
      <v-card-subtitle>Update Sale Order</v-card-subtitle>

      <v-card-text>
        <v-row class="pt-3">
          <v-col cols="12" sm="4">
            <v-text-field v-model="form.ref" label="Reference" learable persistent-placeholder=""/>
          </v-col>

          <v-col cols="12" sm="4">
            <v-text-field v-model="form.date" type="date" label="Date" learable persistent-placeholder=""/>
          </v-col>

          <v-col cols="12" sm="4">
            <v-text-field v-model="form.remarks" label="Remarks" learable persistent-placeholder=""/>
          </v-col>

          <v-col cols="12" sm="4">
            <v-select
              v-model="form.status"
              :items="statusItems"
              item-title="label"
              item-value="value"
              label="Status"
              learable persistent-placeholder=""
            />
          </v-col>

          <v-col cols="12" sm="4">
            <UserDropdown
              v-model="form.user_id"
              label="User"
              learable persistent-placeholder=""
            />
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>


    <v-card class="mt-3" title="Item List">
      <v-card-text>
        <InvoiceItemsSection
          :items="form.items"
          @add="addItem"
          @remove="removeItem"
        />
      </v-card-text>
    </v-card>

    <!-- TOTAL -->
    <v-card class="mt-3" title="Invoice Total">
      <v-card-text>
        <v-row>
          <v-col cols="12" sm="3">
            <v-text-field label="Subtotal" :model-value="subtotal" disabled />
          </v-col>

          <v-col cols="12" sm="3">
            <v-text-field v-model="form.discount" label="Discount (%)" />
          </v-col>

          <v-col cols="12" sm="3">
            <v-text-field v-model="form.tax" label="Tax (%)" />
          </v-col>

          <v-col cols="12" sm="3">
            <v-text-field label="Grand Total" :model-value="grandTotal" disabled />
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <div class="text-center mt-4">
      <v-btn color="primary" @click="updateForm">
        Update
      </v-btn>
    </div>
  </v-container>
</template>
<script>
import InvoiceItemsSection from "./InvoiceItemsSection.vue";
import UserDropdown from "@/components/UserDropdown.vue";
import generaApi from "@/models/general.model";

export default {
  components: { InvoiceItemsSection, UserDropdown },

  data() {
    return {
      loading: false,
      url: "/api/saleOrder",
      form: {
        date: "",
        ref: "",
        remarks: "",
        status: 0,
        discount: 0,
        tax: 0,
        user_id: null,
        items: [],
      },
      statusItems: [
        { label: "Active", value: 1 },
        { label: "Deactive", value: 0 },
      ],
    };
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        const res = await generaApi.find(this.url, id);
        const data = res.data;

        this.form = {
          date: data.date?.split(" ")[0],
          ref: data.ref,
          remarks: data.remarks,
          status: Number(data.status),
          discount: Number(data.discount),
          tax: Number(data.tax),
          user_id: data.user_id,
          items: (data.items || []).map(item => ({
            product_id: item.product_id || "",
            quantity: Number(item.quantity) || 1,
            price: Number(item.price) || 0,
            discount: Number(item.discount) || 0,
            tax: Number(item.tax) || 0,
          })),
        };
      } catch (e) {
        console.error(e);
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
        tax: 0,
      });
    },

    removeItem(index) {
      this.form.items.splice(index, 1);
    },

    async updateForm() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        const updateUrl = `${this.url}/${id}`;

        const payload = {
          date: this.form.date,
          ref: this.form.ref,
          remarks: this.form.remarks,
          status: this.form.status,
          discount: this.form.discount,
          tax: this.form.tax,
          user_id: this.form.user_id,
          items: this.form.items.map(item => ({
            product_id: item.product_id,
            quantity: Number(item.quantity) || 1,
            price: Number(item.price) || 0,
            discount: Number(item.discount) || 0,
            tax: Number(item.tax) || 0,
          })),
        };

        const response = await generaApi.put(updateUrl, payload);

        // Show success popup
        const successMessage = response.data?.message || "Sale Order updated successfully!";
        this.$alertStore.add(successMessage, "success");

        // Redirect after short delay
        setTimeout(() => {
          this.$router.push("/user/saleorder");
        }, 1000);

      } catch (e) {
        console.error(e);

        // Show error popup
        const errorMessage =
          e.response?.data?.message || e.message || "Sale Order update failed";
        this.$alertStore.add(errorMessage, "error");
      } finally {
        this.loading = false;
      }
    }

  },

  computed: {
    subtotal() {
      return this.form.items.reduce((sum, i) => {
        return sum + (i.quantity * i.price - i.discount + i.tax);
      }, 0);
    },
    invoiceDiscountAmount() {
      return (this.subtotal * this.form.discount) / 100;
    },
    invoiceTaxAmount() {
      return ((this.subtotal - this.invoiceDiscountAmount) * this.form.tax) / 100;
    },
    grandTotal() {
      return (this.subtotal - this.invoiceDiscountAmount + this.invoiceTaxAmount).toFixed(2);
    },
  },
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