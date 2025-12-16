<template>
  <v-card :loading="loading" :disabled="loading" title="Item Information" subtitle="Create New Item"> 
    <v-card-text>      
        <v-row class="pt-3">
            <v-col cols="12" sm="12">
                <label class="form-label">Title</label>
                <v-text-field v-model="form.title" height="38px" placeholder="Title" />
            </v-col>

        </v-row>
    </v-card-text>

     <div class="mt-3 text-center">
      <v-btn color="primary"  @click="submitForm">Submit</v-btn>
      <!-- <v-btn color="danger" variant="flat" @click="resetForm">Cancel</v-btn> -->
    </div>
  </v-card>
</template>

<script>
import ProductsModel from "@/models/product.model";
export default {
  data() {
    return {
      loading: false,
      form: {
        title: '',
      },
    }
  },
  computed: {
    imagePreview() {
      if (!this.form.image) return null;
      return URL.createObjectURL(this.form.image);
    }
  },
  methods: {
    async submitForm() {
        this.loading = true;

        try {
            let formData = new FormData();
            formData.append('title', this.form.title);

            let res = await ProductsModel.create(formData);
            this.$alertStore.add(res.message, 'success');
            // this.$router.push('/user/inventory');
            this.$router.push(`/user/inventory/edit/${res.data.id}`);

        } catch (error) {
            console.error(error);
            this.$alertStore.add(error.message, 'error');
        } finally {
            this.loading = false;
            this.resetForm();
        }
    },

    resetForm() {
      this.form = {
        title: '',
      };
    }
  }
}
</script>

<style scoped>
.form-label {
  font-weight: 500;
  margin-bottom: 4px;
  display: block;
}
</style>
