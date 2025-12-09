<template>
  <div class="mainContainer   ">
    <div class="content " style="max-width: 1900px; min-height: 100vh; ">
      <v-row align="center" justify="center">

        <!-- Left: Title + Form -->
        <v-col cols="12" lg="6" class=" pa-md-12  position-relative " style="min-height: 100vh;">

          <!-- Background Image -->
          <!-- Background Image -->
          <v-card class="position-absolute top-0 left-0 elevation-24" :style="{
            width: '100%',
            height: '100%',
            backgroundImage: `url(${bgImage})`,
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            opacity: 0.1,
            zIndex: 1,


          }">

          </v-card>


          <!-- Form Content -->
          <div class="position-relative pa-8 pa-md-12 mt-16  align-center justify-center "
            style="z-index: 2; max-width: 600px; margin: auto;  ">
            <h1 class="text-h6 text-lg-h4  text-md-h5 text-white font-weight-bold mb-10 text-center text-lg-start">
              Supported Page
            </h1>

            <div class="max-w-md mx-auto mx-lg-0">
              <v-text-field label="Name" v-model="form.name" placeholder="John Doe" variant="outlined"
                bg-color="inputBg" base-color="gray-lighten-1" color="white" class="mb-6"></v-text-field>

              <v-text-field label="Email" v-model="form.email" placeholder="john@example.com" variant="outlined"
                bg-color="inputBg" base-color="grey-lighten-1" color="white" class="mb-6"></v-text-field>

              <v-textarea label="Description *" v-model="form.description"
                placeholder="I have a question about my subscription..." variant="outlined" bg-color="inputBg"
                base-color="grey-lighten-1" color="white" rows="5" class="mb-8"></v-textarea>

              <div class="d-flex  flex-sm-row mb-8" style="max-width: 200px;">
                <v-btn color="primary" class="flex-grow-1 mr-lg-10 text-capitalize" @click="formSubmit">
                  Submit
                </v-btn>
                <v-btn color="white" class="flex-grow-1 ml-lg-0 ml-4  text-surface  text-capitalize" to="/">
                  Go Back
                </v-btn>
              </div>

              <p class="text-light text-body-2">
                Hey! If you have a code-related question, please instead use
                <a href="#" class="text-primary text-decoration-none">the forum</a>.
              </p>
            </div>
          </div>

        </v-col>

        <!-- Right: Quick Links -->
        <v-col cols="12" lg="6" class=" pa-8   pa-md-12 d-flex align-center justify-center bg-surface" style="min-height: 100vh;">
          <div class="w-100 " style="max-width: 560px;">
            <div v-for="(item, index) in quickLinks" :key="index"
              class="mb-4 px-6 py-1  border-thin rounded-sm bg-background">
              <div class="d-flex align-center justify-space-between">
                <span class="text-white text-body-1">{{ item.heading }}</span>

                <v-btn icon @click="toggle(index)" variant="plain">
                  <v-icon color="grey-lighten-2" size="20">
                    {{ activeIndex === index ? 'mdi-minus' : 'mdi-plus' }}
                  </v-icon>
                </v-btn>
              </div>

              <v-expand-transition>
                <div v-if="activeIndex === index" class="mt-3 text-light ">
                  {{ item.description }}
                </div>
              </v-expand-transition>
            </div>
          </div>
        </v-col>

      </v-row>
    </div>
  </div>
</template>


<script>
import UserModel from '@/models/user.model';
import bgImage from "@/assets/images/reauction/Reauction.png"
import quickLinks from "@/json/support.json"

export default {
  name: 'support',

  data: () => ({
    bgImage,
    quickLinks ,
    activeIndex: null,
    form: {
      name: "",
      email: "",
      description: ""
    }
  }),
  methods: {
    async formSubmit() {
      try {

        let formResponse = ({
          name: this.form.name,
          email: this.form.email,
          description: this.form.description
        })
        let res = await UserModel.supportForm(formResponse);
        this.$alertStore.add('Form Submited Succesfully', 'success');
        this.form.name = "";
        this.form.email = "";
        this.form.description = "";


      } catch (error) {
        this.$alertStore.add(error, 'error');

      }
    },
    
    toggle(index) {
      this.activeIndex = this.activeIndex === index ? null : index;
    }

  }
}
</script>

<style scoped>
.inner-shadow {
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
}
</style>