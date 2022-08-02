<template>
  <div class="ma-4 pa-4">
    <v-navigation-drawer permanent app>
      <v-card>
        <v-list>
          <v-list-item>
            <v-list-item-icon>
              <v-avatar size="32">
                <v-btn color="#e8c46a" href="/mypage">
                  <span class="white--text text-h6">{{ avatarName }}</span>
                </v-btn>
              </v-avatar>
            </v-list-item-icon>
            <v-list-item-title>{{ user.name }} </v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-content>
              <v-list-item-subtitle>{{ user.email }} </v-list-item-subtitle>

              <v-list-item-title
                class="text-h6"
                style="text-overflow: inherit; white-space: unset"
              >
                <span class="text-caption" v-if="user.is_company">
                  <v-icon small>mdi-domain</v-icon>
                  {{ user.company.name }} /
                  <v-icon small>mdi-card-account-details</v-icon>
                  {{ user.role.name }}
                </span>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <span v-for="menu in menus" :key="menu.id">
          <v-list nav dense v-if="menu.has_role">
            <v-list-item link :href="menu.route_name">
              <v-list-item-icon>
                <v-icon>{{ menu.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-title>{{ menu.menu_name }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </span>
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
    },

    async getUser() {
      const result = await axios.get('api/me')

      this.user = result.data
      console.log(this.user.role.name)
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
