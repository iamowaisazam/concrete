<template>
  <div class="bg-background ">
    <aboutscreen />
    <div class="bg-surface">
      <Dealer />
    </div>
    <exists />
  </div>
  <card />
  <mision />
  <problem/>
  <autodifferent/>
  <promise/>
  <bidSmarter/>
</template>

<script>

import aboutscreen from './aboutscreen.vue';
import Dealer from './dealer.vue';
import exists from './exists.vue';
import card from './card.vue';
import mision from './mision.vue';
import problem from './problem.vue';
import autodifferent from './autodifferent.vue';
import promise from './promise.vue';
import bidSmarter from './bidSmarter.vue';


export default {
  components: {
  name: 'About',
    aboutscreen,
    Dealer,
    exists,
    card,
    mision,
    problem,
    autodifferent,
    promise,
    bidSmarter,
  }
}
</script>