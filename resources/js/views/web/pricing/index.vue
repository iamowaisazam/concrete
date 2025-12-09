<template>
  <pricingplain/>
  <featureTable/>
</template>


<script>
  import pricingplain from './pricingplain.vue';
  import featureTable from './featureTable.vue';
  
  export default {
      components: {
        name: 'pricing',
        pricingplain,
        featureTable
      }
  }
</script>