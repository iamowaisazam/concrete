<template>
  <v-card :loading="loading" :disabled="loading" 
          title="Unit Information" 
          subtitle="Edit Unit">
    <v-card-text>
      <v-row class="pt-3">

        <v-col cols="12">
          <label class="form-label">Title</label>
          <v-text-field v-model="form.title" placeholder="Title" height="38px"/>
        </v-col>

      </v-row>
    </v-card-text>

    <div class="mt-3 text-center">
      <v-btn color="primary" @click="submitForm">Update</v-btn>
      <!-- <v-btn color="danger" variant="flat" @click="resetForm">Cancel</v-btn> -->
    </div>
  </v-card>
</template>

<script>
import unitModel from "@/models/unit.model";

export default {
  data() {
    return {
      loading: false,
      form: {
        title: '',
      },

    };
  },
  computed: {
  
  },
  mounted() {
    this.loadInventory();
  },
  methods: {
    async loadInventory() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        const res = await unitModel.find({ id });
        const data = res.data;

        this.form.title = data.title;
    
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
        const id = this.$route.params.id;
        const res = await unitModel.update(id, formData);

        this.$alertStore.add(res.message || 'Unit updated', 'success');
        this.$router.push('/user/unit');

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

</style>
