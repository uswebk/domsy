<template>
  <div class="ma-12 pa-12">
    <v-navigation-drawer permanent expand-on-hover app>
      <v-card>
        <v-list>
          <v-list-item>
            <v-list-item-icon>
              <v-avatar color="#e8c46a" size="28">
                <span class="white--text text-h6">{{ avatarName }}</span>
              </v-avatar>
            </v-list-item-icon>
          </v-list-item>

          <v-list-item link>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                {{ user.name }}
              </v-list-item-title>
              <v-list-item-subtitle>{{ user.email }} </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list nav dense v-for="menu in menus" :key="menu.id">
          <v-list-item link :href="menu.index_route">
            <v-list-item-icon>
              <v-icon>mdi-monitor-dashboard</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{ menu.name }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-card>

      <template v-slot:append>
        <v-list-item link @click="logout">
          <v-list-item-icon>
            <v-icon>mdi-logout-variant</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item>
      </template>
    </v-navigation-drawer>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      avatarName: '',
      user: {},
      menus: {},
    }
  },

  methods: {
    async getMenus() {
      const result = await axios.get('/api/menus')

      this.menus = result.data

      console.log(this.menus)
    },

    async getUser() {
      const result = await axios.get('api/me')

      this.user = result.data
      this.avatarName = result.data.name.charAt(0)
    },

    async logout() {
      await axios.post('/logout')

      location.href = '/'
    },
  },

  created() {
    this.getUser()
    this.getMenus()
  },
}
</script>
