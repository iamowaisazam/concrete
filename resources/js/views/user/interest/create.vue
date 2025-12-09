<template>
    <div class="pa-4 text-center">
        <v-dialog v-model="dialog" max-width="1000">
            <template v-slot:activator="{ props: activatorProps }">
                <v-btn class="text-none font-weight-regular" prepend-icon="mdi-account" text="Edit Profile"
                    variant="tonal" v-bind="activatorProps"></v-btn>
            </template>
            <v-card prepend-icon="mdi-thumb-up" title="Create Intrest">
                <v-card-text>
                
                    <v-row dense>
                        <v-col cols="12" >
                            <h4>Primary</h4>
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                            <v-text-field 
                              label="Title"
                              v-model="form.title"
                              prepend-inner-icon="mdi-email"
                              persistent-placeholder
                              variant="outlined"
                              placeholder="Your Interest Title" />
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                            <v-autocomplete 
                              label="Make"
                              variant="outlined"
                              v-model="form.make" 
                              chips 
                              placeholder="Select Make"
                              prepend-inner-icon="mdi-email"
                              auto-select-first
                              :items="items"
                              persistent-placeholder
                              multiple />
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                              <v-autocomplete 
                                variant="outlined"  
                                prepend-inner-icon="mdi-email"
                                :items="items"
                                v-model="form.model"
                                placeholder="Select Model"
                                persistent-placeholder
                                label="Model" 
                                chips
                                auto-select-first 
                                multiple />
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                              <v-autocomplete 
                                 variant="outlined"  
                                 prepend-inner-icon="mdi-email"
                                 chips
                                 :items="items"
                                 v-model="form.variant"
                                 label="Variant" 
                                 auto-select-first 
                                 multiple />
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-autocomplete 
                                      variant="outlined" 
                                      v-model="form.year_from"
                                      :items="items" 
                                      label="Year From" 
                                      persistent-placeholder />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete 
                                       v-model="form.year_to"
                                       variant="outlined" 
                                       :items="items" 
                                       label="Year To" 
                                       persistent-placeholder />
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-autocomplete variant="outlined" :items="items" label="Mileage From" persistent-placeholder />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete variant="outlined" :items="items" label="Mileage To" persistent-placeholder />
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col cols="12" >
                            <h4 class="" >Secondary</h4>
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                                <v-autocomplete 
                                label="Fuel Type"
                                variant="outlined"
                                v-model="form.make" 
                                chips 
                                placeholder="Select Fuel Type"
                                prepend-inner-icon="mdi-email"
                                auto-select-first
                                :items="items"
                                persistent-placeholder
                                multiple />
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                                <v-autocomplete 
                                label="CC"
                                variant="outlined"
                                v-model="form.make" 
                                chips 
                                placeholder="Select CC"
                                prepend-inner-icon="mdi-email"
                                auto-select-first
                                :items="items"
                                persistent-placeholder
                                multiple />
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-autocomplete 
                                      variant="outlined" 
                                      v-model="form.year_from"
                                      :items="items" 
                                      label="Price (CAP Clean) From" 
                                      persistent-placeholder />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete 
                                       v-model="form.year_to"
                                       variant="outlined" 
                                       :items="items" 
                                       label="Price (CAP Clean) To" 
                                       persistent-placeholder />
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                                <v-autocomplete 
                                    label="Transmission"
                                    variant="outlined"
                                    v-model="form.make" 
                                    chips 
                                    placeholder="Select Transmission"
                                    prepend-inner-icon="mdi-email"
                                    auto-select-first
                                    :items="items"
                                    persistent-placeholder
                                    multiple />
                        </v-col>
                        <v-col cols="12" md="4" sm="6">
                                <v-autocomplete 
                                    label="Grade"
                                    variant="outlined"
                                    v-model="form.make" 
                                    chips 
                                    placeholder="Select Grade"
                                    prepend-inner-icon="mdi-email"
                                    auto-select-first
                                    :items="items"
                                    persistent-placeholder
                                    multiple />
                        </v-col>
                     
                    </v-row>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text="Close" variant="plain" @click="dialog = false"></v-btn>
                    <v-btn color="primary" text="Save" variant="tonal" @click="dialog = false"></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import { useInterestStore } from '@/stores/interestStore';
import { useAlertStore } from '@/stores/alertStore';



export default {
    props: {

    },
    components: {
    
    },
    data() {
        return {
            form: {
                title:'',
                make: null,
                model: null,
                variant: null,
                year_from: null,
                year_to:null,
            },
            interestStore: useInterestStore(),
            alertStore: useAlertStore(),
            dialog: true,
            items: [
                'Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump'
            ]
        }

    },
    methods: {

    }
};
</script>

<style scoped></style>
