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
            <v-row justify="center" class="d-flex align-center">
              <v-col cols="1">
                <v-avatar size="46" color="#e8c46a">
                  <!-- TODO: use Emoji -->
                  <span class="white--text text-h4"> {{ me.avatarName }} </span>
                </v-avatar>
              </v-col>
              <v-col cols="3">
                <v-text-field
                  v-model="name"
                  label="Name"
                  type="text"
                  hide-details="false"
                  :error-messages="errors.canceled_at"
                ></v-text-field>
              </v-col>
              <v-col cols="2">
                <v-btn small>Save</v-btn>
              </v-col>
            </v-row>
            <v-divider class="my-10"></v-divider>
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
  data() {
    return {
      errors: [],
    }
  },
  computed: {
    ...mapGetters('menu', ['menus', 'pageLoading']),
    ...mapGetters('authentication', ['me']),
    menuItems() {
      return this.menus.filter(function (menu) {
        return menu.has_role
      })
    },
    name() {
      return this.me.name
    },
  },
}
</script>
