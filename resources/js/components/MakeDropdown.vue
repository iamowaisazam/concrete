<template>
    <v-select
        v-bind="$attrs"
        :model-value="modelValue"
        :items="data"
        item-title="label"
        item-value="id"
        :loading="loading"
        @update:model-value="handleValue($event)"
        />  
</template>

<script>
import Make from "@/models/make.model";

import { debounce } from "lodash";


export default {
    name: "MakeSelect",
    props: {
        modelValue: {
            type: [String, Number,Boolean],
            default: null
        },
       
    },
    data() {
        return {
            value:null,
            data: [],
            loading: false,
        };
    },
    mounted(){
        this.fetchPlatforms();
    },
    methods: {

        async fetchPlatforms() {
                this.loading = true;
                try {
                    const response = await Make.get({});
                    this.data = response.data; 
                } catch (err) {
                    console.error("Error loading Makes:", err);
                    this.data = [];
                } finally {
                    this.loading = false;
                }
        },
        handleValue(value) {
            this.$emit("update:modelValue", value);
        },
    },
    emits: ['update:modelValue']
};
</script>

<style scoped>
    
</style>