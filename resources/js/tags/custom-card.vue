<template>
    <v-card :class="['bg-surface', 'border', 'card', this.class ]">
        
        <div v-if="title || subtitle" class="card-header border-bottom" >
            <h3 v-if="title" class="card-title text-h5">{{ title }}</h3>
            <p v-if="subtitle" class="text-body-1 subtitle">{{ subtitle }}</p>
        </div>

        <div class="card-body">
            <slot></slot>
        </div>
        
 
     </v-card>
</template>

<script>

export default {
    props: {
        class: {
          type:String,
          default: "",
        },
        title: {
          type:String,
          default: "",
        },
        subtitle: {
          type:String,
          default: "",
        }
    },
    data() {
        return {

        }
    },
    computed: {

    },
    methods: {

    }
};

</script>

<style scoped >

.border-bottom{
    border-bottom: 1px solid rgb(var(--v-theme-border));
}

.card-header{
    padding: 24px 24px;
}

.subtitle{
    color:rgb(var(--v-theme-light))
}


</style>
