<template>
  <v-alert dense text dismissible :type="type" v-if="message">
    {{ message }}
  </v-alert>
</template>

<script>
export default {
  name: 'GreetingMessage',
  props: {
    type: {
      default: '',
      type: String,
      required: true,
    },
    message: {
      default: '',
      type: String,
      required: true,
    },
  },
}
</script>
