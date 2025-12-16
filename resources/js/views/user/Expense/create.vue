<template>
  <v-card
    :loading="loading"
    :disabled="loading"
    title="Expense Information"
    subtitle="Create New Expense Item"
  >
    <v-card-text>
      <v-row class="pt-3">



        <!-- Date -->
        <v-col cols="12" sm="6">
          <label class="form-label">Date</label>
          <v-text-field
            v-model="form.date"
            type="date"
          />
        </v-col>

        <!-- Debit -->
        <v-col cols="12" sm="6">
          <label class="form-label">Debit</label>
          <v-text-field
            v-model="form.debit"
            type="number"
            placeholder="Enter debit amount"
          />
        </v-col>

        <!-- Credit -->
        <v-col cols="12" sm="6">
          <label class="form-label">Credit</label>
          <v-text-field
            v-model="form.credit"
            type="number"
            placeholder="Enter credit amount"
          />
        </v-col>

        <!-- Category Dropdown -->
        <v-col cols="12" sm="6">
          <label class="form-label">Category</label>
          
          <ExpenseCategory 
            v-model="form.category_id"
            clearable  
            placeholder="Select category" />

        </v-col>

        <!-- Remarks -->
        <v-col cols="12">
          <label class="form-label">Remarks</label>
          <v-textarea
            v-model="form.remarks"
            rows="3"
            placeholder="Enter remarks"
          />
        </v-col>

      </v-row>
    </v-card-text>

     <div class="mt-16 text-center">
      <v-btn color="primary"  @click="submitForm">
        Submit
      </v-btn>
      <!-- <v-btn color="danger" variant="flat" @click="resetForm">
        Cancel
      </v-btn> -->
    </div>
  </v-card>
</template>


<script>

import expenseModel from "@/models/expense.model";
import ExpenseCategory from "@/components/ExpenseCategory.vue";



export default {
  components:{
    ExpenseCategory
  },
  data() {
    return {
      loading: false,

      form: {
        
        date: "",
        debit: "",
        credit: "",
        remarks: "",
        category_id: null,
      },
    };
  },

  mounted() {

  },

  methods: {
 

    async submitForm() {
      this.loading = true;
      try {
        const formData = new FormData();

        Object.keys(this.form).forEach(key => {
          if (this.form[key] !== "" && this.form[key] !== null) {
            formData.append(key, this.form[key]);
          }
        });

        const res = await expenseModel.create(formData);

        this.$alertStore.add(res.message || "Expense created", "success");
        // this.$router.push(`/user/expense/edit/${res.data.id}`);
        this.$router.push("/user/expense");

      } catch (error) {
        console.error(error);
        this.$alertStore.add(error.message || "Failed to submit", "error");
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.form = {
        title: "",
        date: "",
        debit: "",
        credit: "",
        remarks: "",
        category_id: null,
      };
    },
  },
};
</script>

