<template>

  <v-container>

    <v-card 
      :loading="loading" 
      :disabled="loading" 
      title="Delivery Note" 
      subtitle="Create Delivery Note">
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
      url :"/api/deliveryNotes",
      form: {
        date: "",
        ref: "",
        remarks: "",
        status: "pending",
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
        await generaApi.post(this.url, payload);
        this.$router.push("/user/deliverynote");

      } catch (e) {
        console.error("Create failed:", e);
        this.$alertStore.add("Sale Order creation failed", "error");
      } finally {
        this.loading = false;
      }
    }




  },
  computed: {


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
