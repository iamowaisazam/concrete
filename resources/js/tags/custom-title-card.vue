<template>
         <h5 :class="class" class="text-h5"><slot></slot></h5>
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
    methods: {

    }
};

</script>

<style scoped >

</style>
