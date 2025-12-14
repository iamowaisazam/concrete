<template>
  <v-card :loading="loading" :disabled="loading" 
          title="Expense Category Information" 
          subtitle="Edit Expense Category Item">
    <v-card-text>
      <v-row class="pt-3">
        <!-- Title -->
        <v-col cols="12" sm="6">
          <label class="form-label">Title</label>
          <v-text-field v-model="form.title" placeholder="Enter title" height="38px"/>
        </v-col>


        <!-- Image upload -->
        <v-col cols="12" sm="6">
          <label class="form-label">Image</label>
          <v-file-input
            v-model="form.image"
            label="Upload Image"
            prepend-icon="mdi-camera"
            variant="filled"
            accept="image/*"
          />
        </v-col>

        <!-- Image preview -->
        <v-col cols="12" sm="6" style="margin-top: 20px;">
          <v-img v-if="imagePreview" :src="imagePreview" width="100" height="80" contain />
        </v-col>


      </v-row>
    </v-card-text>

    <v-card-actions>
      <v-btn color="primary" variant="flat" @click="submitForm">Update</v-btn>
      <v-btn color="danger" variant="flat" @click="resetForm">Cancel</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import expenseCategoryModel from "@/models/expensecategory.model";

export default {
  data() {
    return {
      loading: false,
      form: {
        title: '',
        image: null,
      },
      originalImage: null,
    };
  },
  computed: {
    imagePreview() {
      if (this.form.image) {
        return typeof this.form.image === 'string' ? this.form.image : URL.createObjectURL(this.form.image);
      }
      return this.originalImage;
    }
  },
  mounted() {
    this.loadInventory();
  },
  methods: {
    async loadInventory() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        const res = await expenseCategoryModel.find({ id });
        const data = res.data;

        this.form.title = data.title;
        this.originalImage = data.image;
      } catch (error) {
        console.error(error);
        this.$alertStore.add("Failed to load inventory", "error");
      } finally {
        this.loading = false;
      }
    },

    async submitForm() {
    this.loading = true;
    try {
        const formData = new FormData();

        formData.append('title', this.form.title);

        if (this.form.image instanceof File) {
        formData.append('image', this.form.image);
        }

        const id = this.$route.params.id;

        const res = await expenseCategoryModel.update(id, formData);

        this.$alertStore.add(res.message || 'Expense Category updated', 'success');
        this.$router.push('/user/expensecategory');

    } catch (error) {
        console.error(error);
        this.$alertStore.add(error.message || 'Failed to submit', 'error');
    } finally {
        this.loading = false;
    }
    },


    resetForm() {
      this.loadInventory();
    }
  }
};
</script>

<style scoped>
.form-label {
  font-weight: 500;
  margin-bottom: 4px;
  display: block;
}
</style>
