<template>
      <div :style="style"></div>
</template>

<script>


export default {
    name: "v-space",
    props: {

    },
    computed: {
        style() {
            return {
                padding:'10px 0px',
            }
        }
    }
};
</script>

<style>

</style>
