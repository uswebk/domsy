<template>
  <v-form ref="form" class="pa-4">
    <v-text-field
      v-model="authModel.name"
      label="Name"
      required
      :error-messages="errors.name"
    ></v-text-field>
    <v-text-field
      v-model="authModel.email"
      label="Email"
      required
      :error-messages="errors.email"
    ></v-text-field>
    <v-text-field
      v-model="authModel.password"
      label="Password"
      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
      :type="showPassword ? 'text' : 'password'"
      name="password"
      hint="At least 8 characters"
      counter
      :error-messages="errors.password"
      @click:append="showPassword = !showPassword"
    ></v-text-field>
    <v-text-field
      v-model="authModel.password_confirmation"
      label="Confirm Password"
      type="password"
      name="password_confirmation"
      counter
      required
      :error-messages="errors.password_confirmation"
    ></v-text-field>
    <div class="my-5"></div>
    <v-btn class="mr-4" color="primary" @click="register"> Register </v-btn>
    <nuxt-link to="login"> Already have an account? </nuxt-link>
  </v-form>
</template>

<script>
import { mapMutations, mapActions } from 'vuex'

export default {
  name: 'IndividualForm',
  data() {
    return {
      authModel: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        emoji: '',
      },
      errors: {},
      showPassword: false,
    }
  },
  methods: {
    ...mapMutations('authentication', ['pageLoading']),
    ...mapActions('authentication', {
      registerAction: 'register',
      sendMessage: 'sendMessage',
    }),
    resetForm() {
      this.authModel = {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        emoji: '',
      }
    },
    async register() {
      try {
        this.authModel.emoji = this.$getEmoji()
        await this.registerAction(this.authModel)

        this.sendMessage({
          greeting: 'We have sent you an approval email.',
          greetingType: 'success',
        })

        this.resetForm()
      } catch (error) {
        const errors = error.response.data.errors
        const errorTmp = {}
        for (const key in errors) {
          errorTmp[key] = errors[key][0]
        }
        this.errors = errorTmp
        this.pageLoading(false)
      }
    },
  },
}
</script>
