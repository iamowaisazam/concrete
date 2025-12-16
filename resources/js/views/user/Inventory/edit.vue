<template>
  <v-card :loading="loading" :disabled="loading" 
          title="Item Information" 
          subtitle="Edit Item">
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
        <v-col cols="12" sm="4">
          <label class="form-label">Price</label>
          <v-text-field v-model="form.price" type="number" placeholder="Enter price" height="38px"/>
        </v-col>

        <!-- Unit -->
        <v-col cols="12" sm="4">
          <label class="form-label">Unit</label>
          <UnitDropdown 
            v-model="form.unit_id"
            clearable  
            placeholder="Select Unit" />
        </v-col>

        <v-col cols="12" sm="4">
          <label class="form-label">Category</label>
          <CategoryDropdown 
            v-model="form.category_id"
            clearable  
            placeholder="Select Category" />
        </v-col>

        <v-col cols="12" sm="6">
          <label class="form-label">Image</label>
          <v-file-input
            v-model="form.image"
            label="Upload Image"
            prepend-icon="mdi-file"
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
          <v-textarea variant="outlined" v-model="form.description" rows="3" placeholder="Enter description" />
        </v-col>
      </v-row>
    </v-card-text>

    <v-card-actions style="margin-top: 60px;">
      <v-btn color="primary" variant="flat" @click="submitForm">Update</v-btn>
      <v-btn color="danger" variant="flat" @click="resetForm">Cancel</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import ProductsModel from "@/models/product.model";
import CategoryDropdown from "@/components/CategoryDropdown.vue";
import UnitDropdown from "@/components/UnitDropdown.vue";

export default {
  components:{
    CategoryDropdown,
    UnitDropdown
  },
  data() {
    return {
      loading: false,
      form: {
        title: '',
        sku: '',
        price: '',
        unit_id: '',
        category_id: '',
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
        this.form.unit_id = data.unit_id;
        this.form.category_id = data.category_id;
        this.form.description = data.description;
        this.originalImage = data.image_preview;
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
        formData.append('unit_id', this.form.unit_id);
        formData.append('category_id', this.form.category_id);
        formData.append('description', this.form.description);

        if (this.form.image instanceof File) {
        formData.append('image', this.form.image);
        }

        const id = this.$route.params.id;

        const res = await ProductsModel.update(id, formData);

        this.$alertStore.add(res.message || 'Inventory updated', 'success');
        // this.$router.push('/user/inventory');

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

