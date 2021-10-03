<template>
    <a-config-provider :locale="ru_RU">
      <div>
        <a-row>
          <a-col :span="8" class="w-expenses-col">
            <w-expenses-card :loading="!day" :data="day" :add="true" @expenseAdded="loadData"/>
          </a-col>

          <a-col :span="8" class="w-expenses-col">
            <w-expenses-card :loading="!week" :data="week"/>
          </a-col>

          <a-col :span="8" class="w-expenses-col">
            <w-expenses-card :loading="!month" :data="month"/>
          </a-col>
        </a-row>
        <a-row>
          <a-col :span="24" class="w-expenses-col-single">
            <w-expenses-stats/>
          </a-col>
        </a-row>
      </div>
    </a-config-provider>
</template>

<script>
  import ru_RU from 'ant-design-vue/lib/locale-provider/ru_RU'

  import ExpensesCard from './components/ExpensesCard.vue'
  import ExpensesStats from './components/ExpensesStats.vue'

  import Stats from './services/stats'

  export default {
    name: 'App',
    components: {
      'w-expenses-card': ExpensesCard,
      'w-expenses-stats': ExpensesStats,
    },
    data() {
      return {
        ru_RU,

        day: null,
        week: null,
        month: null,
      }
    },
    created() {
      this.loadData()

    },
    methods: {
      loadData() {
        this.day = null;
        Stats.expensesForToday().then(data => this.day = data)

        this.week = null;
        Stats.expensesForWeek().then(data => this.week = data)

        this.month = null;
        Stats.expensesForMonth().then(data => this.month = data)
      }
    }
  }
</script>

<style lang="less" scoped>
  .w-expenses-col, .w-expenses-col-single {
    padding: 5px;
  }
  .w-expenses-col:first-child {
    padding-right: 0;
  }
  .w-expenses-col:last-child {
    padding-left: 0;
  }
</style>