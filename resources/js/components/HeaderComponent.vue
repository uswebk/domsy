<template>
  <div>
    <v-app-bar dense app>
      <v-toolbar-title>Domsy</v-toolbar-title>
      <v-spacer />

      <v-menu bottom left offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-avatar color="#e8c46a" size="28" v-bind="attrs" v-on="on">
            <span class="white--text text-h6">{{ AvatarName }}</span>
          </v-avatar>
        </template>

        <v-list>
          <v-list-item link>
            <a href="/settings" style="color: #333; text-decoration: none">
              <v-icon left> mdi-cog </v-icon>Settings</a
            >
          </v-list-item>

          <v-list-item link @click="logout">
            <v-icon left> mdi-logout-variant </v-icon>Logout
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      AvatarName: '',
    }
  },

  methods: {
    async getUser() {
      const result = await axios.get('api/me')

      this.AvatarName = result.data.name.charAt(0)
    },

    async logout() {
      await axios.post('/logout')

      location.href = '/'
    },
  },

  created() {
    this.getUser()
  },
}
</script>
