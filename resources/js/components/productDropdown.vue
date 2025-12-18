<template>
    <v-select
        v-bind="$attrs"
        :model-value="modelValue"
        :items="data"
        item-title="title"
        item-value="id"
        :loading="loading"
        @update:model-value="handleValue($event)"
        />  
</template>

<script>
import ProductsModel from "@/models/product.model";

export default {
    name: "ProductDropdown",
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
        this.getData();
    },
    methods: {

        async getData() {
                this.loading = true;
                try {
                    const response = await ProductsModel.all({length:1000});
                    this.data = response.data; 
                } catch (err) {
                    console.error("Error loading platforms:", err);
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