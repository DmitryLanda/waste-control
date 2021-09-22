<template>
    <a-config-provider :locale="ru_RU">
      <div>
        <a-row>
          <a-col :span="8" class="w-expenses-col">
            <w-expenses-card :loading="!day" :data="day" :add="true" @add-expense="displayExpenseCreationModal"/>
          </a-col>

          <a-col :span="8" class="w-expenses-col">
            <w-expenses-card :data="week"/>
          </a-col>

          <a-col :span="8" class="w-expenses-col">
            <w-expenses-card :data="month"/>
          </a-col>
        </a-row>
        <a-row>
          <a-col :span="24" class="w-expenses-col-single">
            <w-expenses-stats/>
          </a-col>
        </a-row>
        <a-modal v-model="displayModal" title="Доход / Расход" @ok="addNewExpense">
          <w-add-expense ref="form"/>
        </a-modal>
      </div>
    </a-config-provider>
</template>

<script>
  import moment from 'moment'
  import 'moment/locale/ru'
  import ru_RU from 'ant-design-vue/lib/locale-provider/ru_RU'

  import ExpensesCard from './components/ExpensesCard.vue'
  import ExpensesStats from './components/ExpensesStats.vue'
  import AddExpense from "./components/AddExpense"

  import Expenses from './services/expenses'

  moment.locale('ru');

  export default {
    name: 'App',
    components: {
      'w-expenses-card': ExpensesCard,
      'w-expenses-stats': ExpensesStats,
      'w-add-expense': AddExpense
    },
    data() {
      return {
        ru_RU,
        displayModal: false,
        day: null,
      }
    },
    created() {
      this.loadData()

    },
    computed: {
      week: () => Expenses.expensesForWeek(),
      month: () => Expenses.expensesForMonth()
    },
    methods: {
      async loadData() {
        const day = await Expenses.expensesForToday()
        this.day = day
        console.log(this.day)
      },
      displayExpenseCreationModal() {
        alert('modal')
        this.displayModal = true
      },
      addNewExpense(event) {
        const data = this.$refs.form.submit()
        console.log('form')
        this.displayModal = false

        this.day = Expenses.expensesForToday()
        this.week = Expenses.expensesForWeek()
        this.month = Expenses.expensesForMonth()
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