<template>

  <v-container>

    <v-card 
      :loading="loading" 
      :disabled="loading" 
      title="Sale Order " 
      subtitle="Create Sale Order">
      <v-card-text>
          <v-row class="pt-3">
            <v-col cols="12" sm="4">
       
              <v-text-field v-model="form.ref" label="Reference"clearable persistent-placeholder=""/>
            </v-col>
            <v-col cols="12" sm="4">
         
              <v-text-field v-model="form.date" type="date" label="Date"clearable persistent-placeholder=""/>
            </v-col>
            
            
            <v-col cols="12" sm="4">
        
              <v-text-field v-model="form.remarks" label="Remarks" clearable persistent-placeholder=""/>
            </v-col>
            <v-col cols="12" sm="4">

              <v-select
                v-model="form.status"
                :items="statusItems"
                item-title="label"
                item-value="value"
                label="Status"
                clearable
              />

            </v-col>
            <v-col cols="3" sm="4">
              <UserDropdown
                    v-model="form.user_id"
                    label="Users"
                    clearable persistent-placeholder=""
                />
            </v-col>

          </v-row>
      </v-card-text>
    </v-card>
    <v-card :loading="loading" :disabled="loading" class="mt-3" title="Item List" >
      <v-card-text >
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
import generaApi from "@/models/general.model"
import UserDropdown from "@/components/UserDropdown.vue"
export default {
  components: {
    InvoiceItemsSection,
    UserDropdown
  },

  data() {
    return {
      loading: false,
      url :"/api/saleOrder", 
      form: {
        date: "",
        ref: "",
        remarks: "",
        status: "",
        discount: 0,
        tax: 0,
        user_id: null,
        items: [],
        
      },
      statusItems: [
        { label: "Active ", value: 1 },
        { label: "Deactive", value: 0 },
        ],
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
    const payload = {
      date: this.form.date,
      ref: this.form.ref,
      remarks: this.form.remarks,
      status: this.form.status,
      discount: this.form.discount,
      tax: this.form.tax,
      user_id: this.form.user_id,
      items: this.form.items
        .filter(item => item.product_id)
        .map(item => ({
          product_id: item.product_id,
          quantity: Number(item.quantity) || 1,
          price: Number(item.price) || 0,
          discount: Number(item.discount) || 0,
          tax: Number(item.tax) || 0,
        })),
    };

    const response = await generaApi.post(this.url, payload);

    // Show success popup
    const successMessage = response.data?.message || "Sale Order created successfully!";
    this.$alertStore.add(successMessage, "success");

    // Redirect after a short delay so user can see the message
    setTimeout(() => {
      this.$router.push("/user/saleorder");
    }, 1000);

  } catch (e) {
    console.log(e);
    const errorMessage =
      e.response?.data?.message || e.message || "Sale Order creation failed";
    this.$alertStore.add(errorMessage, "error");
  } finally {
    this.loading = false;
  }
}






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
