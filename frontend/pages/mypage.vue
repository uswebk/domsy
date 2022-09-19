<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <h1 class="text-h5 font-weight-bold">
            <v-icon large>mdi-account-box</v-icon> Mypage
          </h1>
          <div class="py-5"></div>
          <v-progress-linear
            v-show="pageLoading"
            color="yellow darken-2"
            indeterminate
            rounded
            height="6"
          ></v-progress-linear>
          <v-container class="pa-14">
            <v-row dense justify="start">
              <v-col v-for="menu in menuItems" :key="menu.id" cols="4">
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
                    <v-btn outlined rounded text :to="menu.endpoint" nuxt>
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
  </common-base-frame>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'MyPage',
  computed: {
    ...mapGetters('menu', ['menus', 'pageLoading']),
    menuItems() {
      return this.menus.filter(function (menu) {
        return menu.has_role
      })
    },
  },
}
</script>
