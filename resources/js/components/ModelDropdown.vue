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
import Model from "@/models/vehicle-model.model";
import { debounce } from "lodash";


export default {
    name: "ModelDropdown",
    props: {
        modelValue: {
            type: [String, Number,Boolean],
            default: null
        },
        make: {
            type: [String, Number,Boolean],
            default: null
        },
       
    },
    data() {
        return {
            data: [],
            loading: false,
        };
    },
    mounted(){
        // this.getData();
    },
    watch: {
        // Method 1: Simple – just name the prop
        make(newValue, oldValue) {
            this.$emit('update:modelValue', null);
            if (newValue) {
                this.getData()
            } else {
                this.data = [];
                this.$emit('update:modelValue', null);
            }
        },
    },
    methods: {
        async getData() {
                this.loading = true;
                try {
                    const response = await Model.get({
                        makes: [this.make],
                        length: 1000
                    });
               
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