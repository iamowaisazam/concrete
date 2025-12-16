<template>
  <v-card
    :loading="loading"
    :disabled="loading"
    title="Payment Information"
    subtitle="Edit Payment Details"
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
         <div  class="mt-3 text-center w-100">
            <v-btn class="mr-1" color="primary"  @click="submitForm">
                Update
            </v-btn>
            <!-- <v-btn color="danger" variant="flat" @click="resetForm">
                Cancel
            </v-btn> -->
        </div>

      </v-row>
    </v-card-text>
  </v-card>
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
        _method:'put',
        date: "",
        amount:0,
        type:null,
        remarks: "",
        user_id: null,
      },
    };
  },

  mounted() {
 
    this.loadExpense();
  },

  methods: {

    async loadExpense() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        const res = await paymentModel.find({id});

        const data = res.data;
        console.log(data)
        this.form.date = data.date;
        if(data.type == 'debit'){
            this.form.amount = data.debit;
        }else{
            this.form.amount = data.credit;
        }
        this.form.type = data.type;
        this.form.remarks = data.remarks;
        this.form.user_id = data.user_id;

      } catch (e) {
        this.$alertStore.add("Failed to load expense", "error");
      } finally {
        this.loading = false;
      }
    },

    async submitForm() {
      this.loading = true;
      try {

        const id = this.$route.params.id; 
        const res = await paymentModel.update(id, this.form);
        this.$alertStore.add(res.message || "Payment updated", "success");
        this.$router.push("/user/payments");

      } catch (error) {
        this.$alertStore.add(error.message || "Update failed", "error");
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.loadExpense();
    }
  },
};
</script>

