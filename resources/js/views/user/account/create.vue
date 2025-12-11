<template>

      <v-card class="" title="General Form" subtitle="All with bootstrap element classies" > 
        <v-card-text>
      
            <v-row  class="pt-3" >
                <v-col cols="12" sm="4">
                    <label for="" class="form-label" >Name</label>
                    <v-text-field class="" v-model="form.name" height="38px" />
                </v-col>
                <v-col cols="12" sm="4">
                    <label for="" class="form-label" >Email</label>
                    <v-text-field v-model="form.email" />
                </v-col>
                <v-col cols="12" sm="4">
                    <label for="" class="form-label" >Phone</label>
                    <v-text-field v-model="form.phone" />
                </v-col>
                <v-col cols="12" sm="12">
                    <label for="" class="form-label" >Address</label>
                    <v-text-field v-model="form.address"  />
                </v-col>
                <v-col cols="12" sm="12">
                    <label for="" class="form-label" >Description</label>
                    <v-text-field v-model="form.description" />
                </v-col>
            </v-row>
    
        </v-card-text>
        <v-card-actions>
          <v-btn class="v-btn" to="/user/account" variant="flat" color="primary" @click="submitForm">Submit</v-btn>
          <v-btn class="v-btn" to="/user/account" variant="flat" color="danger">Cancel</v-btn>
        </v-card-actions>
      </v-card>

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


<style>

  
</style>