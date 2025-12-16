<template>
      <v-card :loading="loading" :disabled="loading" class="" title="Account Information" subtitle="Create New User Account" > 
        <v-card-text>      
            <v-row  class="pt-3" >
                <v-col cols="12" >
                    <label for="" class="form-label" >Fullname</label>
                    <v-text-field class="" v-model="form.firstName" height="38px" />
                </v-col>
            </v-row>
        </v-card-text>
        <div class="mt-3 text-center" >
            <v-btn color="primary" @click="submitForm">Save</v-btn>
        </div>
      </v-card>

</template>

<script>
import UserModel from '@/models/user.model';

export default {
    data() {

        return {
            loading:false,
            form: {
                firstName: "",
            },
        };
  },
  methods: {
   async submitForm() {

        try {
                
            this.loading = true;
            let res = await UserModel.create(this.form);
            this.loading = false;
            this.$alertStore.add(res.message,'success');
            this.$router.push('/user/account/edit/' + res.data.id);




        } catch (error) {
             this.loading = false;
             this.$alertStore.add(error.message,'error');
        }
    
    },
    handle(value){
        
        // this.open = value;        
    }

  },
};
</script>


<style>

  
</style>