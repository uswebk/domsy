<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <h1 class="text-h5 font-weight-bold">
            <v-icon large>mdi-account-box</v-icon> Mypage
          </h1>
          <div class="py-5"></div>
          <common-greeting-message
            :type="greetingType"
            :message="greeting"
          ></common-greeting-message>
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
                <v-avatar
                  size="52"
                  color="#efefef"
                  style="cursor: pointer"
                  @click="openEmojiPicker"
                >
                  <span class="white--text text-h5">
                    {{ userModel.emoji }}
                  </span>
                </v-avatar>
                <v-dialog v-model="shownEmoji" max-width="325px">
                  <v-emoji-picker @select="selectEmoji"></v-emoji-picker>
                </v-dialog>
              </v-col>
              <v-col cols="3">
                <v-text-field
                  v-model="userModel.name"
                  label="Name"
                  type="text"
                  hide-details="false"
                  :error-messages="errors.canceled_at"
                ></v-text-field>
              </v-col>
              <v-col cols="2">
                <v-btn small @click="update">Save</v-btn>
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
import { mapGetters, mapActions } from 'vuex'
import { VEmojiPicker } from 'v-emoji-picker'

export default {
  name: 'MyPage',
  components: {
    VEmojiPicker,
  },
  data() {
    return {
      errors: [],
      shownEmoji: false,
      emoji: '🦁',
    }
  },
  computed: {
    ...mapGetters('menu', ['menus', 'pageLoading']),
    ...mapGetters('authentication', ['me']),
    ...mapGetters('account', ['greeting', 'greetingType']),
    menuItems() {
      return this.menus.filter(function (menu) {
        return menu.has_role
      })
    },
    userModel() {
      return Object.assign({}, this.me)
    },
  },
  methods: {
    ...mapActions('account', ['updateProfile', 'sendMessage']),
    ...mapActions('authentication', ['fetchMe']),
    selectEmoji(emoji) {
      this.shownEmoji = false
      this.userModel.emoji = emoji.data
    },
    openEmojiPicker() {
      this.shownEmoji = true
    },
    async update() {
      try {
        await this.updateProfile(this.userModel)
        this.fetchMe()

        this.sendMessage({
          greeting: 'Update Profile Success',
          greetingType: 'success',
        })
      } catch (error) {
        const status = error.response.status

        if (status === 422) {
          const errors = error.response.data.errors
          const _errors = {}
          for (const key in errors) {
            _errors[key] = errors[key][0]
          }
          this.errors = _errors
          this.loading = false
        }
      }
    },
  },
}
</script>
