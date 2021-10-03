<template>
    <a-card :loading="loading" :bordered="false" class="expense-card">
      <a slot="title" class="expense-card-title" href="#">{{ title }}</a>
      <a-button v-if="add && !loading" slot="extra" href="#" type="primary" @click="processExpenseCreation">
        <a-icon type="plus"/>
      </a-button>
      <w-money :value="total" type="down"/>
      <w-category-stats :categories="categories" :values="values" height="30vh"/>

      <a-modal
          v-if="add"
          v-model="displayModal"
          title="Доход / Расход"
          @ok="addNewExpense"
          @cancel="discardChanges"
          :confirm-loading="saving"
      >
        <a-input v-model="expression" required="required" autoFocus allowClear @pressEnter="addNewExpense" ref="expression"/>
      </a-modal>
    </a-card>
</template>

<script>
import CategoryStats from './CategoryStats.vue';
import Money from './Money.vue';

import Expenses from "../services/expenses";

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
      displayModal: false,
      expression: null,
      saving: false
    }
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
  methods: {
    processExpenseCreation() {
      setTimeout(() => {
        this.$refs.expression.focus()
      })
      this.displayModal = true
    },
    discardChanges() {
      this.displayModal = false
      this.saving = false
      this.expression = null
    },
    addNewExpense() {
      this.saving = true
      Expenses.addExpense({expression: this.expression}).then(success => {
        this.saving = false

        if (success) {
          this.discardChanges()
          this.$emit('expenseAdded')
        }
      })
    }

  }
}
</script>

<style lang="less">
  .expense-card {
    height: 310px;
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
