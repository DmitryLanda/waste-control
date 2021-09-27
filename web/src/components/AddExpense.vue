<template>
  <a-form-model
      :model="form"
      :rules="rules"
      ref="form"
      :label-col="{ span: 5 }"
      :wrapper-col="{ span: 18 }"
      class="w-add-expense"
  >
    <a-form-model-item label="Причина" ref="comment" prop="comment">
      <a-input v-model="form.comment"/>
    </a-form-model-item>
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
import api from '../services/api'

export default {
  name: "w-add-expense",
  data() {
    return {
      form: {amount: null, category: null, date: moment(), comment: null},
      rules: {
        date: [{ required: true, message: 'Выберите дату' }],
        amount: [{ required: true, message: 'Укажите сумму' }],
        category: [{ required: true, message: 'Выберите категорию' }],
        comment: []
      },
      categories: []
    }
  },
  methods: {
    submit() {
      this.$refs.form.validate(valid => valid)

      return this.form
    },
    reset() {
      this.$refs.form.resetFields()
    },
    async loadCategories() {
      const { data } = await api.get('/categories')

      return this.categories = data
    }

  },
  created() {
    this.loadCategories()
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