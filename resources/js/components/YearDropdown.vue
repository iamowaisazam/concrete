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
import Auction from "@/models/auction.model";



export default {
    name: "YearSelect",
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
                    const response = await Auction.getYears({});
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