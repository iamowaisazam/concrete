<template>

        <div class="card-header" :class="class" >
            <slot></slot>
        </div>
</template>

<script>

export default {
    props: {
        class: {
          type:String,
          default: "",
        },
    },
    data() {
        return {

        }
    },
    computed: {
        cardHeader() {
            return {

        
            }
        }
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




</style>
