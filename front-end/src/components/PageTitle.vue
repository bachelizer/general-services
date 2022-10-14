<template>
  <div>
    <v-card-title>{{ title }}</v-card-title>
    <v-card-text>{{ subTitle }}</v-card-text>
  </div>
</template>
<script>
export default {
  name: 'PageTitle',
  props: {
    title: {
      type: String,
      default: '',
    },
    subTitle: {
      type: String,
      default: '',
    },
  },
};
</script>
