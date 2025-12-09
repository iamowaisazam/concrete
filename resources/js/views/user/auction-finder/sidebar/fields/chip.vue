<template>
     <span v-for="item in myData">
        <v-chip
          class="bg-primary mr-2" 
          size="x-small"
         >{{ item.label}}
         <v-icon @click="this.removeValue(removeKey,item.id)" icon="mdi-close" end></v-icon>
        </v-chip>
     </span>
</template>

<script>

export default {
    props: {
        data: {
            type: Array,
            default: () => [],
            required: true,
        },
        compareValue: {
            type: Array,
            default: () => [],
            required: true,
        },
        removeKey: {
            type: String,
        }, 
        removeValue: {
            type: Function,
        },  
    },
    data() {
        return {
        }
    },
    methods: {
      
    },
    computed: {
        myData() {

            return this.data.map((item) => {
               
                return {
                    label:item.label,
                    id: item?.id ?  item.id:item.label
                }

            }).filter((item) => {
                if (this.compareValue.includes(item.id)) {
                    return true;
                }
            })

        },
    },
};

</script>