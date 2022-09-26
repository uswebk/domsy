<template>
  <v-row dense justify="start">
    <v-col v-for="menu in menuItems" :key="menu.id" cols="4">
      <v-card outlined>
        <v-list-item three-line>
          <v-list-item-content>
            <v-list-item-title class="text-h6 mb-1">
              {{ menu.menu_name }}
            </v-list-item-title>
            <v-list-item-subtitle>{{ menu.description }} </v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-avatar
            tile
            size="60"
            color="#e8c46a"
            class="rounded-circle"
            ><v-icon color="white">{{ menu.icon }}</v-icon></v-list-item-avatar
          >
        </v-list-item>
        <v-card-actions>
          <v-btn outlined rounded text :to="menu.endpoint" nuxt>
            Link <v-icon small>mdi-link-variant</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'MypageMenuList',
  computed: {
    ...mapGetters('menu', ['menus']),
    menuItems() {
      return this.menus.filter(function (menu) {
        return menu.has_role
      })
    },
  },
}
</script>
