<template>
  <v-alert v-if="shown" dense text dismissible :type="type">
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
  computed: {
    shown() {
      return this.message !== ''
    },
  },
}
</script>
