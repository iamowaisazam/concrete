  <template>

    <v-container>

      <v-card 
        :loading="loading" 
        :disabled="loading" 
        title="Sale Invoice" 
        subtitle="Create Sale Invoice">
        <v-card-text>
            <v-row class="pt-3">
              <v-col cols="12" sm="4">
        
                <v-text-field v-model="form.ref" label="Reference"clearable persistent-placeholder=""/>
              </v-col>
              <v-col cols="12" sm="4">
          
                <v-text-field v-model="form.date" type="date" label="Date"clearable persistent-placeholder=""/>
              </v-col>
              <v-col cols="12" sm="4">

                <v-text-field v-model="form.due_date" type="date" label="Due Date"clearable persistent-placeholder="" />
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
                <v-select v-model="form.is_paid" :items="[
                  { text: 'Yes', value: 1 },
                  { text: 'No', value: 0 }
                ]" item-title="text" item-value="value"  label="Paid status" clearable persistent-placeholder=""/>
              </v-col>
              <v-col cols="3" sm="4">
                <UserDropdown
                      v-model="form.user_id"
                      label="Users"
                  />
              </v-col>


            </v-row>
        </v-card-text>
      </v-card>
      <v-card :loading="loading" :disabled="loading" class="mt-3" title="Item List" >
        <v-card-text >
          <InvoiceItemsSection
            :items="form.items"
            :user-id="form.user_id"
            @add="addItem"
            @remove="removeItem"
          />
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
import UserDropdown from "@/components/UserDropdown.vue";

export default {
  components: {
    InvoiceItemsSection,
    UserDropdown,
  },

  data() {
    return {
      loading: false,
      form: {
        date: "",
        due_date: "",
        ref: "",
        remarks: "",
        status: "",
        is_paid: 0,
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

  methods: {
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

async submitForm() {
  this.loading = true;

  try {
    const fd = new FormData();

    fd.append("date", this.form.date);
    fd.append("due_date", this.form.due_date);
    fd.append("ref", this.form.ref);
    fd.append("remarks", this.form.remarks);
    fd.append("status", this.form.status);
    fd.append("discount", this.form.discount);
    fd.append("tax", this.form.tax);
    fd.append("is_paid", this.form.is_paid ? 1 : 0);
    fd.append("user_id", this.form.user_id);

    this.form.items.forEach((item, i) => {
      if (!item.delivery_note_id) return

      fd.append(`items[${i}][delivery_note_id]`, item.delivery_note_id)
      fd.append(`items[${i}][discount]`, item.discount ?? 0)
      fd.append(`items[${i}][tax]`, item.tax ?? 0)
    })



    for (let pair of fd.entries()) {
      console.log(pair[0], pair[1]);
    }

    const response = await saleInvoiceModel.create(fd);


    const successMessage = response.data?.message || "Invoice created successfully!";
    this.$alertStore.add(successMessage, "success");


    setTimeout(() => {
      this.$router.push("/user/saleInvoice");
    }, 1000);

  } catch (e) {
    console.error("Invoice create failed:", e);


    const errorMessage = e.response?.data?.message || e.message || "Invoice creation failed";
    this.$alertStore.add(errorMessage, "error");

  } finally {
    this.loading = false;
  }
}


  },

computed: {

  subtotal() {
    return this.form.items.reduce((sum, item) => {
      const dnTotal = Number(item.delivery_note?.total || 0);
      const itemDiscount = Number(item.discount || 0);
      const itemTax = Number(item.tax || 0);

      return sum + (dnTotal - itemDiscount + itemTax);
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
