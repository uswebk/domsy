<template>
  <div>
    <v-progress-linear
      v-show="loading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <div class="base">
      <slot name="side-navigation">
        <common-side-navigation></common-side-navigation>
      </slot>
      <slot name="main"> &nbsp; </slot>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'BaseFrame',
  computed: {
    ...mapGetters({ loading: 'pageLoading' }),
  },
}
</script>
