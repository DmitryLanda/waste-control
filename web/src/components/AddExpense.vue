<template>
  <a-form-model
      :model="form"
      :rules="rules"
      ref="form"
      :label-col="{ span: 5 }"
      :wrapper-col="{ span: 18 }"
      class="w-add-expense"
  >
    <a-form-model-item label="Дата" ref="date" prop="date">
      <a-date-picker v-model="form.date" />
    </a-form-model-item>
    <a-form-model-item label="Сумма" ref="amount" prop="amount">
      <a-input-number v-model="form.amount" allow-clear autoFocus :precision="2"/>
    </a-form-model-item>
    <a-form-model-item label="Категория" ref="category" prop="category">
      <a-select v-model="form.category" show-search>
        <a-select-option v-for="category in categories" :value="category">{{ category }}</a-select-option>
      </a-select>
    </a-form-model-item>
  </a-form-model>
</template>

<script>
import moment from 'moment'

export default {
  name: "w-add-expense",
  data() {
    return {
      form: {amount: null, category: null, date: moment()},
      rules: {
        date: [{ required: true, message: 'Выберите дату' }],
        amount: [{ required: true, message: 'Укажите сумму' }],
        category: [{ required: true, message: 'Выберите категорию' }]
      },
      categories: ['Кино', 'Бар', 'Авто', 'Проезд', 'Кафе', 'Йцу', 'Ываа','длолд']
    }
  },
  methods: {
    submit() {
      this.$refs.form.validate(valid => valid)

      return this.form
    },
    reset() {
      this.form = {amount: null, category: null, date: moment()}
    }
  }
}
</script>

<style scoped lang="less">
  .w-add-expense {
    .ant-input-number, .ant-calendar-picker {
      width: 100%
    }
  }
</style>