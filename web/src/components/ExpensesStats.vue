<template>
  <a-card :bordered="false" class="expense-card">
    <w-money :value="11.28" type="up"/>
    <w-money :value="34.07" type="down"/>
    <w-overall-stats height="35vh"/>
  </a-card>
</template>

<script>
import OverallStats from './OverallStats.vue';
import Money from './Money.vue';

export default {
  name: 'w-expenses-stats',
  components: {
    'w-overall-stats': OverallStats,
    'w-money': Money,
  }
}
</script>

<style lang="less">

</style>
