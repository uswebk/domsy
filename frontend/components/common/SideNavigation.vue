<template>
  <div class="ma-4 pa-4">
    <v-navigation-drawer permanent app>
      <v-card>
        <v-list>
          <v-list-item>
            <v-list-item-icon>
              <v-avatar size="32">
                <v-btn color="#efefef" to="/mypage" nuxt>
                  <span class="white--text text-h6">{{ me.emoji }}</span>
                </v-btn>
              </v-avatar>
            </v-list-item-icon>
            <v-list-item-title>{{ me.name }} </v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-subtitle>{{ me.email }} </v-list-item-subtitle>
              <v-list-item-title
                class="text-h6"
                style="text-overflow: inherit; white-space: unset"
              >
                <span v-if="me.is_company" class="text-caption">
                  <v-icon small>mdi-domain</v-icon>
                  {{ me.company.name }} /
                  <v-icon small>mdi-card-account-details</v-icon>
                  {{ me.role.name }}
                </span>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <span v-for="menu in menus" :key="menu.id">
          <v-list v-if="menu.has_role" nav dense>
            <v-list-item link :to="menu.endpoint" nuxt>
              <v-list-item-icon>
                <v-icon>{{ menu.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-title>{{ menu.menu_name }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </span>
      </v-card>
      <template #append>
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
import { mapGetters, mapMutations, mapActions } from 'vuex'

export default {
  name: 'SideNavigation',
  computed: {
    ...mapGetters('menu', ['menus']),
    ...mapGetters('authentication', ['me']),
  },
  created() {
    this.fetchMe()
    this.fetchMenus()
  },
  methods: {
    ...mapMutations(['pageLoading']),
    ...mapActions('menu', ['fetchMenus']),
    ...mapActions('authentication', ['fetchMe']),
    ...mapActions('authentication', { logoutAction: 'logout' }),
    async logout() {
      this.pageLoading(true)
      await this.logoutAction()
      this.pageLoading(false)
      location.href = '/login'
    },
  },
}
</script>
