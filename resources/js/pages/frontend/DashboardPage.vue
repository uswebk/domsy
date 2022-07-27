<template>
  <v-main>
    <v-container> </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      menus: {},
    }
  },

  methods: {
    async getMenus() {
      const result = await axios.get('/api/menus')

      this.menus = result.data
    },
  },

  created() {
    this.getMenus()
  },
}
</script>
