<template>
  <div>
    <v-app-bar dense app>
      <v-toolbar-title>Domsy</v-toolbar-title>
      <v-spacer />

      <v-menu bottom left offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-avatar color="#e8c46a" size="25" v-bind="attrs" v-on="on">
            <span class="white--text text-h5">t</span>
          </v-avatar>
        </template>

        <v-list>
          <v-list-item link>
            <a href="/settings" style="color: #333; text-decoration: none"
              >Settings</a
            >
          </v-list-item>

          <v-list-item link @click="logout"> Logout </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data: () => ({
    drawer: false,
  }),

  methods: {
    getUser() {},

    async logout() {
      await axios.post('/logout')

      location.href = '/'
    },
  },
}
</script>
