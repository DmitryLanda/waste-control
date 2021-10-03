<template>
  <a-card :bordered="false" :loading="loading" class="expense-card">
    <a slot="title" class="expense-card-title" href="#">{{ title }}</a>
    <w-money :value="total" type="down"/>
    <w-overall-stats :categories="categories" :values="values" height="34vh"/>
  </a-card>
</template>

<script>
import OverallStats from './OverallStats.vue';
import Money from './Money.vue';

export default {
  name: 'w-expenses-stats',
  props: {
    data: Object,
    loading: Boolean
  },
  components: {
    'w-overall-stats': OverallStats,
    'w-money': Money,
  },
  computed: {
    title() {
      return this.data?.title
    },
    categories() {
      return Object.keys(this.data?.values || [])
    },
    values() {
      return Object.values(this.data?.values || [])
    },
    total() {
      return this.values.reduce((x, y) => x + y, 0);
    }
  },
}
</script>

<style lang="less">

</style>
