<template>
  <v-form ref="form" class="pa-4">
    <v-text-field
      label="Name"
      v-model="authModel.name"
      required
      :error-messages="errors.name"
    ></v-text-field>
    <v-text-field
      label="Email"
      v-model="authModel.email"
      required
      :error-messages="errors.email"
    ></v-text-field>
    <v-text-field
      label="Password"
      v-model="authModel.password"
      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
      :type="showPassword ? 'text' : 'password'"
      name="password"
      hint="At least 8 characters"
      counter
      @click:append="showPassword = !showPassword"
      :error-messages="errors.password"
    ></v-text-field>
    <v-text-field
      label="Confirm Password"
      v-model="authModel.password_confirmation"
      type="password"
      name="password_confirmation"
      counter
      required
      :error-messages="errors.password_confirmation"
    ></v-text-field>
    <div class="my-5"></div>
    <v-btn class="mr-4" color="primary" @click="register"> Register </v-btn>
  </v-form>
</template>

<script>
import { mapMutations, mapActions } from 'vuex'

export default {
  name: 'IndividualForm',
  props: {
    message: {
      type: String,
    },
  },
  data() {
    return {
      authModel: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      errors: {},
      showPassword: false,
    }
  },
  methods: {
    ...mapMutations('auth', ['pageLoading']),
    ...mapActions('auth', {
      registerAction: 'register',
      sendMessage: 'sendMessage',
    }),

    async register() {
      try {
        await this.registerAction(this.authModel)

        this.sendMessage({
          greeting: 'We have sent you an approval email.',
          greetingType: 'success',
        })
      } catch (error) {
        const errors = error.response.data.errors
        const errorTmp = {}
        for (let key in errors) {
          errorTmp[key] = errors[key][0]
        }
        this.errors = errorTmp
        this.pageLoading(false)
      }
    },
  },
}
</script>
