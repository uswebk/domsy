<template>
  <v-container style="padding: 0" fill-height fluid>
    <v-row
      class="d-flex"
      style="height: 100%; padding: 0"
      align-content="center"
      justify="center"
    >
      <v-col md="4" align="center">
        <slot name="message"> &nbsp; </slot>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'ErrorFrame',
  props: {
    error: {
      type: Object,
      default: null,
    },
  },
  head() {
    const title = '403 Forbidden'
    return {
      title,
    }
  },
}
</script>
