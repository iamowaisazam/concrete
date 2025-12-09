<template>
         <p :class="class" class="text-body-1"><slot></slot></p>
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
