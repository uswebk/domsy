<template>
  <v-app dark>
    <common-error-frame>
      <template #message>
        <h1>{{ errorMessage }}</h1>
        <br />
        <v-btn small href="/" color="primary">Back Top</v-btn>
      </template>
    </common-error-frame>
  </v-app>
</template>

<script>
export default {
  name: 'EmptyLayout',
  layout: 'empty',
  props: {
    error: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      pageNotFound: '404 Not Found',
      otherError: 'An error occurred',
    }
  },
  head() {
    let title = ''
    if (this.error.statusCode === 403) {
      title = '403 Forbidden'
    } else if (this.error.statusCode === 404) {
      title = '404 Not Found'
    } else {
      title = 'Server Error'
    }
    return {
      title,
    }
  },
  computed: {
    errorMessage() {
      if (this.error.statusCode === 403) {
        return '404 Forbidden'
      }
      if (this.error.statusCode === 404) {
        return '404 Not Found'
      }

      return 'Server Error'
    },
  },
}
</script>

<style scoped>
h1 {
  font-size: 20px;
}
</style>
