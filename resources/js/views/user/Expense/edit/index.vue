<template>
  <v-card
    :loading="loading"
    :disabled="loading"
    title="Expense Information"
    subtitle="Edit Expense Item"
  >
    <v-card-text>
      <v-row class="pt-3">

        <!-- Date -->
        <v-col cols="12" sm="6">
          <label class="form-label">Date</label>
          <v-text-field v-model="form.date" type="date" />
        </v-col>

        <!-- Debit -->
        <v-col cols="12" sm="6">
          <label class="form-label">Amount</label>
          <v-text-field v-model="form.debit" type="number" />
        </v-col>

        <!-- Credit -->
        <!-- <v-col cols="12" sm="6">
          <label class="form-label">Credit</label>
          <v-text-field v-model="form.credit" type="number" />
        </v-col> -->

        <!-- Category -->
        <v-col cols="12" sm="6">
          <label class="form-label">Category</label>
          <v-select
            v-model="form.category_id"
            :items="categories"
            item-title="title"
            item-value="id"
            clearable
          />
        </v-col>

        <!-- Remarks -->
        <v-col cols="12">
          <label class="form-label">Remarks</label>
          <v-textarea v-model="form.remarks" rows="3" />
        </v-col>

      </v-row>
    </v-card-text>

     <div class="mt-16 text-center">
      <v-btn color="primary"  @click="submitForm">
        Update
      </v-btn>
      <!-- <v-btn color="danger" variant="flat" @click="resetForm">
        Cancel
      </v-btn> -->
    </div>
  </v-card>
</template>


<script>
import expenseCategoryModel from "@/models/expensecategory.model";
import expenseModel from "@/models/expense.model";

export default {
  data() {
    return {
      loading: false,
      categories: [],
      form: {
        date: "",
        debit: "",
        
        remarks: "",
        category_id: null,
      },
    };
  },

  mounted() {
    this.loadCategories();
    this.loadExpense();
  },

  methods: {
    async loadCategories() {
      const res = await expenseCategoryModel.all();
      this.categories = res.data;
    },

    async loadExpense() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        const res = await expenseModel.find(id);

        const data = res.data;
        console.log(data)
        this.form.date = data.date;
        this.form.debit = data.debit;
        this.form.remarks = data.remarks;
        this.form.category_id = data.category_id;

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
        const formData = new FormData();

        Object.keys(this.form).forEach(key => {
          if (this.form[key] !== "" && this.form[key] !== null) {
            formData.append(key, this.form[key]);
          }
        });

        formData.append("_method", "put");

        const res = await expenseModel.update(id, formData);

        this.$alertStore.add(res.message || "Expense updated", "success");
        this.$router.push("/user/expense");

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


<style scoped>
.form-label {
  font-weight: 500;
  margin-bottom: 4px;
  display: block;
}
</style>
