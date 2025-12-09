<template>
        <select 
            :class="class" 
            v-model="value" 
            @change="handleChangeAction" 
            :placeholder="placeholder" 
            >
            <option value="">{{ placeholder }}</option>
            <option v-for="item in data" :value="item.id">{{ item.label }}</option>
        </select>
</template>
<script>

export default {
    props: {
        data: {
            type: Array,
            default:[],
        },
        class: {
            type: String,
            default:'',
        },
        placeholder: {
            type: String,
            default:'Select',
        },
        defaultValue: {
            type: String,
            default:'',
        }
    },
    data() {
        return {
            value:this.defaultValue,
        }
    },
    methods: {
        handleChangeAction() {
            this.$emit('update:selected',this.value);
        }
    },
   
};

</script>


<style>




</style>