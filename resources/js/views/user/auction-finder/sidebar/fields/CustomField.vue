<template>
    <div v-for="item in data" :key="item[itemValueKey]">
          <v-checkbox   
             v-model="selectedValue"
             :label="String(item[itemLabelKey])" 
             :value="String(item[itemValueKey])"
             @change="handleChangeAction"
             />
    </div>
</template>

<script>

export default {
    props: {
        data: {
            type: Array,
            default: () => [],
            required: true,
        },
        itemLabelKey: {
            type:[String, Number],
            default: 'label',
        },
        itemValueKey: {
            type:[String, Number],
            default: 'id', 
        },
        field: {
            type: String,
        },  
    },
    data() {
        return {
            selectedValue:[],
        }
    },
    methods: {
        handleChangeAction() {
            this.$emit('update:selected', {
                field: this.field,
                value:this.selectedValue
            });
        }
    },
    computed: {
      
    },
};

</script>