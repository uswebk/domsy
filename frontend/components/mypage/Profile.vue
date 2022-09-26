<template>
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
        :error-messages="errors.name"
      ></v-text-field>
    </v-col>
    <v-col cols="2">
      <v-btn small @click="update">Save</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import { VEmojiPicker } from 'v-emoji-picker'

export default {
  name: 'MypageProfile',
  components: {
    VEmojiPicker,
  },
  data() {
    return {
      errors: [],
      shownEmoji: false,
    }
  },
  computed: {
    ...mapGetters('authentication', ['me']),
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

        this.errors = []
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
