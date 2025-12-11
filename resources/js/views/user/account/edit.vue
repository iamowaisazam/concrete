<template>
  <v-container>
    <!-- <v-btn color="primary" @click="dialog = true" @update:modelValue="hanlde" >Open Form</v-btn> -->

    <v-dialog :model-value="open"  max-width="700">
      <v-card>
        <v-card-title class="text-h6">
          Account
        </v-card-title>
        <v-card-text>
            <v-row>
                <v-col cols="12" sm="4">
                    <v-text-field
                        v-model="form.name"
                        label="Name"
                        variant="outlined"
                        density="comfortable"
                        />
                </v-col>
                <v-col cols="12" sm="4">
                    <v-text-field
                        v-model="form.email"
                        label="Email"
                        variant="outlined"
                        density="comfortable"
                        />
                </v-col>
                <v-col cols="12" sm="4">
                    <v-text-field
                        v-model="form.phone"
                        label="Phone"
                        variant="outlined"
                        density="comfortable"
                        />
                </v-col>
                <v-col cols="12" sm="12">
                    <v-text-field
                        v-model="form.address"
                        label="Address"
                        variant="outlined"
                        density="comfortable"
                        />
                </v-col>
                <v-col cols="12" sm="12">
                    <v-text-field
                        v-model="form.description"
                        label="Description"
                        variant="outlined"
                        density="comfortable"
                        />
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn text @click="open = false">Cancel</v-btn>
          <v-btn color="primary" @click="submitForm">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
export default {
    props:{
        dialog: {
            type: Boolean,
            default: false,
        },
    },
    data() {

        return {
            open:true,
            form: {
                name: "",
                email: "",
                phone: "",
                address: "",
                description: "", 
            },
        };
  },
  methods: {
    submitForm() {

      console.log("Form Data:", this.form);
      this.dialog = false;

    },
    handle(value){
        
        // this.open = value;        
    }

  },
};
</script>
