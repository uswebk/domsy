<template>
  <span class="red--text text-sm-body-2 py-2 ma-0" v-text="message"></span>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
    },
  },
}
</script>
