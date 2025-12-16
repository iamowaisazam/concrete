<template>
  <v-card :loading="loading" :disabled="loading" title="Unit" subtitle="Create New Unit"> 
    <v-card-text>      
        <v-row class="pt-3">
            <v-col cols="12" >
                <label class="form-label">Title</label>
                <v-text-field v-model="form.title" height="38px" placeholder="Title" />
            </v-col>

        </v-row>
    </v-card-text>

    <div class="mt-3 text-center" >
      <v-btn color="primary" @click="submitForm">Save</v-btn>
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

            let res = await unitModel.create(formData);
            this.$alertStore.add(res.message, 'success');
            this.$router.push('/user/unit');

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

</style>
