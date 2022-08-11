<template>
  <h1 class="text-h5 font-weight-bold">
    <v-icon large>{{ icon }}</v-icon> {{ headlineText }}
  </h1>
</template>

<script>
export default {
  name: 'IconHeadLine',
  props: {
    icon: {
      default: '',
      type: String,
      required: true,
    },
    headlineText: {
      default: '',
      type: String,
      required: true,
    },
  },
}
</script>
