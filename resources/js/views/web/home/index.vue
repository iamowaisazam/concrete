<template>

  <div class="bg-white">
    <screen />
    <vision />
    <Trusted />
    <wining/>
  </div>
</template>

<script>
import screen from './screen.vue'
import vision from './vision.vue';
import Trusted from './Trusted.vue';
import wining from './wining.vue';

export default {
  name: 'Home',
  components: {
    screen,
    vision,
    Trusted,
    wining
  }
}
</script>
