<template>
  <a-card :bordered="false" class="expense-card" :loading="loading">
    <a slot="title" href="#" class="expense-card-title">{{ title }}</a>
    <a-button type="primary" slot="extra" href="#" v-if="add" @click="dispatchExpenseCreation">
      <a-icon type="plus" />
    </a-button>
    <w-money :value="total"/>
    <w-category-stats :categories="categories" :values="values" height="30vh"/>
  </a-card>
</template>

<script>
import CategoryStats from './CategoryStats.vue';
import Money from './Money.vue';

export default {
  name: 'w-expenses-card',
  components: {
    'w-category-stats': CategoryStats,
    'w-money': Money,
  },
  props: {
    data: Object,
    add: Boolean,
    loading: Boolean
  },
  data() {
    return {
      title: this.data?.title,
    }
  },
  computed: {
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
  methods: {
    dispatchExpenseCreation() {
      this.$emit('add-expense')
    }
  }
}
</script>

<style lang="less">
  .expense-card {
    .ant-card-head {
      min-height: 35px;
      font-size: 14px;
      padding: 0;

      .ant-card-head-title {
        padding: 5px 24px;
      }

      .ant-card-extra {
        padding: 0;
      }
    }

    .ant-card-body {
      padding-top: 5px;
    }
  }
</style>
