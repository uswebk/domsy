<template>
  <v-main>
    <v-container>
      <!-- <div class="d-flex justify-content-left flex-wrap">
        <div class="card w-25 m-1" v-for="menu in menus" :key="menu.id">
          <div class="card-body">
            <h5 class="card-title">{{ menu.name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              {{ menu.description }}
            </h6>

            <div v-for="menu_item in menu.menu_items" :key="menu_item.id">
              <a
                :href="menu_item.route_name"
                class="card-link"
                v-if="menu_item.is_screen"
              >
                {{ menu_item.name }}
              </a>
            </div>
          </div>
        </div>
      </div> -->
    </v-container>
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
