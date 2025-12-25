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
import InvoiceItemsSection from "./InvoiceItemsSection.vue";
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
        status: 1,
        is_paid: 0,
        discount: 0,
        tax: 0,
        user_id: null,
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
    const invoice = res.data;

    this.form.date = invoice.date?.split(" ")[0];
    this.form.due_date = invoice.due_date?.split(" ")[0];
    this.form.ref = invoice.ref;
    this.form.remarks = invoice.remarks;
    this.form.status = Number(invoice.status);
    this.form.is_paid = Number(invoice.is_paid);
    this.form.discount = Number(invoice.discount);
    this.form.tax = Number(invoice.tax);
    this.form.user_id = invoice.user_id;
    this.form.items = invoice.items.map(item => ({
      delivery_note_id: item.delivery_note_id,
      quantity: 1,                
      price: Number(item.total),
      discount: Number(item.discount),
      tax: Number(item.tax),
    }));

  } catch (e) {
    console.error(e);
  } finally {
    this.loading = false;
  }
},



 
    addItem() {
      this.form.items.push({
        delivery_note_id: null,
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
        fd.append("_method", "PUT");

   
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
          if (!item.delivery_note_id) return;

          fd.append(`items[${i}][delivery_note_id]`, item.delivery_note_id);
          fd.append(`items[${i}][quantity]`, item.quantity);
          fd.append(`items[${i}][price]`, item.price);
          fd.append(`items[${i}][discount]`, item.discount);
          fd.append(`items[${i}][tax]`, item.tax);
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
  },

  computed: {
    subtotal() {
      return this.form.items.reduce((sum, item) => {
        return sum + (
          (Number(item.quantity) * Number(item.price))
          - Number(item.discount)
          + Number(item.tax)
        );
      }, 0);
    },

    invoiceDiscountAmount() {
      return (this.subtotal * Number(this.form.discount)) / 100;
    },

    invoiceTaxAmount() {
      return ((this.subtotal - this.invoiceDiscountAmount) * Number(this.form.tax)) / 100;
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
