<template>
    <v-select
    v-bind="$attrs"
    :model-value="modelValue"
    :items="data"
    item-title="title"
    item-value="id"
    :loading="loading"
    @update:model-value="handleValue"
    />

</template>

<script>
import generaApi from "@/models/general.model"

export default {
    name: "DeliveryNoteDropdown",
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
            url :"/api/deliveryNotes"
        };
    },
    mounted(){
        this.getData();
    },
    methods: {

        async getData() {
        this.loading = true;
        try {
            const res = await generaApi.all(this.url, { length: 1000 });

            this.data = res.data.map(item => ({
            id: item.id,
            title: `${item.ref} - ${item.id} `,
            // title: `${item.ref} - ${item.date}`,
            }));

        } catch (err) {
            console.error("Error loading delivery notes:", err);
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