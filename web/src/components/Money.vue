<template>
  <div class="w-money">
    <a-statistic
        :value="value"
        suffix="₽"
        :class="'w-money-' + type"
    />
  </div>
</template>

<script>
export default {
  name: 'w-money',
  props: {
    value: {
      type: Number,
      required: true
    },
    type: {
      type: String,
      validator: (val) => ['normal', 'up', 'down'].indexOf(val) !== -1,
      default: 'normal'
    }
  }
}
</script>

<style lang="less">
  @import '../theme/variables';

  .w-money {
    width: auto;
    display: inline-block;

    .w-money-up .ant-statistic-content {
      color: @success-color
    }

    .w-money-down .ant-statistic-content {
      color: @error-color
    }

    .w-money-normal .ant-statistic-content {
      color: @text-color
    }

    .ant-statistic {
      margin-right: 10px;
    }
  }
</style>
