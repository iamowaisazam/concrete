<template>
  <v-container>

  <v-card
    :loading="loading"
    :disabled="loading"
    title="Payment Information"
    subtitle="Create New Payment"
  >
    <v-card-text>
      <v-row class="pt-3">
        <v-col cols="12" sm="6">
          <label class="form-label">Date</label>
          <v-text-field
            v-model="form.date"
            type="date"
          />
        </v-col>

        <!-- Debit -->
        <v-col cols="12" sm="6">
          <label class="form-label">Type</label>
          <v-select
            v-model="form.type"
            :items="['debit','credit']"
            placeholder="debit/credit"
          />
        </v-col>

        <!-- Credit -->
        <v-col cols="12" sm="6">
          <label class="form-label">Amount</label>
          <v-text-field
            v-model="form.amount"
            type="number"
            placeholder="Amount"
          />
        </v-col>

        <!-- Category Dropdown -->
        <v-col cols="12" sm="6">
          <label class="form-label">Account</label>
          <UserDropdown 
            v-model="form.user_id"
            clearable  
            placeholder="Select Account" />

        </v-col>

        <!-- Remarks -->
        <v-col cols="12">
          <label class="form-label">Remarks</label>
          <v-text-field
            v-model="form.remarks"
            variant="outlined"
            placeholder="Remarks"
          />
        </v-col>

         <div class="mt-3 text-center w-100">
                <v-btn class="mr-1" color="primary" @click="submitForm">
                Submit
              </v-btn>
              <!-- <v-btn color="danger" variant="flat" @click="resetForm">
                Cancel
              </v-btn> -->
        </div>

        

      </v-row>
    </v-card-text>
     </v-card>
    </v-container>
</template>


<script>
import paymentModel from "@/models/payment.model";
import UserDropdown from "@/components/UserDropdown.vue";



export default {
  components:{
    UserDropdown
  },
  data() {
    return {
      loading: false,

      form: {
        type:null,
        date: "",
        amount: "",
        remarks: "",
        user_id: null,
      },
    };
  },

  mounted() {

  },

  methods: {
 

    async submitForm() {
      this.loading = true;
      try {

        const res = await paymentModel.create(this.form);
        this.$alertStore.add(res.message || "Payment created", "success");
        this.$router.push("/user/payments");

      } catch (error) {
        console.error(error);
        this.$alertStore.add(error.message || "Failed to submit", "error");
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.form = {
        date: "",
        amount: "",
        type:null,
        remarks:null,
        user_id: null,
      };
    },
  },
};
</script>

