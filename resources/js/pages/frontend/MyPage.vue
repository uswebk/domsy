<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-account-box</v-icon> Mypage
      </h1>

      <div class="py-5"></div>

      <v-progress-linear
        v-show="!finishInitialize"
        color="yellow darken-2"
        indeterminate
        rounded
        height="6"
      ></v-progress-linear>

      <v-container class="pa-14">
        <v-row dense>
          <v-col cols="4" v-for="menu in menus" :key="menu.id">
            <v-card outlined>
              <v-list-item three-line>
                <v-list-item-content>
                  <v-list-item-title class="text-h6 mb-1">
                    {{ menu.menu_name }}
                  </v-list-item-title>
                  <v-list-item-subtitle
                    >{{ menu.description }}
                  </v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-avatar
                  tile
                  size="60"
                  color="#e8c46a"
                  class="rounded-circle"
                  ><v-icon color="white">{{
                    menu.icon
                  }}</v-icon></v-list-item-avatar
                >
              </v-list-item>

              <v-card-actions>
                <v-btn outlined rounded text :href="menu.route_name">
                  Link <v-icon small>mdi-link-variant</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      finishInitialize: false,
      menus: {},
    }
  },

  methods: {
    async getMenus() {
      this.finishInitialize = false

      const result = await axios.get('/api/menus')

      this.menus = result.data

      this.finishInitialize = true
    },
  },

  created() {
    this.getMenus()
  },
}
</script>
