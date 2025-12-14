<template>
  <v-card :loading="loading" :disabled="loading" 
          title="Inventory Information" 
          subtitle="Edit Inventory Item">
    <v-card-text>
      <v-row class="pt-3">
        <!-- Title -->
        <v-col cols="12" sm="6">
          <label class="form-label">Title</label>
          <v-text-field v-model="form.title" placeholder="Enter inventory title" height="38px"/>
        </v-col>

        <!-- SKU -->
        <v-col cols="12" sm="6">
          <label class="form-label">SKU</label>
          <v-text-field v-model="form.sku" placeholder="Enter SKU" height="38px"/>
        </v-col>

        <!-- Price -->
        <v-col cols="12" sm="6">
          <label class="form-label">Price</label>
          <v-text-field v-model="form.price" type="number" placeholder="Enter price" height="38px"/>
        </v-col>

        <!-- Unit -->
        <v-col cols="12" sm="6">
          <label class="form-label">Unit</label>
          <v-text-field v-model="form.unit" placeholder="Enter unit" height="38px"/>
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

        <!-- Description -->
        <v-col cols="12">
          <label class="form-label">Description</label>
          <v-textarea v-model="form.description" rows="3" placeholder="Enter description" />
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
import ProductsModel from "@/models/product.model";

export default {
  data() {
    return {
      loading: false,
      form: {
        title: '',
        sku: '',
        price: '',
        unit: '',
        description: '',
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
        const res = await ProductsModel.find({ id });
        const data = res.data;

        this.form.title = data.title;
        this.form.sku = data.sku;
        this.form.price = data.price;
        this.form.unit = data.unit || '';
        this.form.description = data.description;
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
        formData.append('sku', this.form.sku);
        formData.append('price', this.form.price);
        formData.append('unit', this.form.unit);
        formData.append('description', this.form.description);

        if (this.form.image instanceof File) {
        formData.append('image', this.form.image);
        }

        const id = this.$route.params.id;

        const res = await ProductsModel.update(id, formData);

        this.$alertStore.add(res.message || 'Inventory updated', 'success');
        this.$router.push('/user/inventory');

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
