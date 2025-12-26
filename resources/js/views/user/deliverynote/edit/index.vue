<template>
  <v-container>
    <v-card
      :loading="loading"
      :disabled="loading"
    >
      <v-card-title>Edit Delivery Note</v-card-title>
      <v-card-subtitle>Update Delivery Noter</v-card-subtitle>

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
  components: {
    InvoiceItemsSection,
    UserDropdown,
  },

  data() {
    return {
      loading: false,

      url: "/api/deliveryNotes",
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
        { label: "Active", value: 1 },
        { label: "Deactive", value: 0 },
      ],
    };
  },

  mounted() {
    this.id = this.$route.params.id;
    this.fetchData();
  },

  methods: {
    async fetchData() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        const res = await generaApi.find(this.url, id);
  
        this.form = {
          date: res.data.date,
          ref: res.data.ref,
          remarks: res.data.remarks,
          status: Number(res.data.status),
          discount: res.data.discount,
          tax: res.data.tax,
          user_id: res.data.user_id,
          items: res.data.items || [],
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


        setTimeout(() => {
          this.$router.push("/user/deliverynote");
        }, 1000);

      } catch (e) {
        console.error("Update failed:", e);


        const errorMessage = e.response?.data?.message || e.message || "Sale Order update failed";
        this.$alertStore.add(errorMessage, "error");

      } finally {
        this.loading = false;
      }
    }



  },

  computed: {

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