<template>
  <div>
    <v-layout justify-center align-center wrap bottom>
      <v-card
        v-for="menu in menuItems"
        :key="menu.id"
        :href="menu.endpoint"
        class="px-5 ma-2"
        style="min-width: 140px"
      >
        <v-card-text>
          <v-layout justify-center column align-center>
            <v-flex class="mt-5">
              <v-avatar size="60" :color="getColor(menu.id) + ' lighten-1'">
                <v-icon dark>{{ menu.icon }}</v-icon>
              </v-avatar>
            </v-flex>
            <p class="subheading mt-2 text-xs-center">{{ menu.menu_name }}</p>
          </v-layout>
        </v-card-text>
      </v-card>
    </v-layout>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'MenuList',
  data() {
    return {}
  },
  computed: {
    ...mapGetters('menu', ['menus']),
    ...mapGetters('authentication', ['me']),
    menuItems() {
      if (this.menus.length === 0 && this.me.email_verified_at) return []
      const menus = this.menus.filter(function (menu) {
        return menu.has_role
      })
      menus.unshift({
        id: 0,
        icon: 'mdi-account-box',
        menu_name: 'Mypage',
        endpoint: 'mypage',
      })

      return menus
    },
  },
  methods: {
    getColor(id) {
      const colors = [
        'indigo',
        'blue',
        'purple',
        'light-blue',
        'cyan',
        'teal',
        'green',
        'light-green',
        'lime',
        'amber',
        'blue-grey',
      ]
      return colors[id % colors.length]
    },
  },
}
</script>
