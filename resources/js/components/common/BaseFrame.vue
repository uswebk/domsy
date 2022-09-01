<template>
  <v-app>
    <v-progress-linear
      v-show="loading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <div class="base">
      <slot name="side-navigation">
        <side-navigation></side-navigation>
      </slot>
      <slot name="main"> &nbsp; </slot>
    </div>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
import SideNavigation from './SideNavigation.vue'
export default {
  name: 'BaseFrame',
  components: { SideNavigation },
  computed: {
    ...mapGetters('common', { loading: 'pageLoading' }),
  },
}
</script>
