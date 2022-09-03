<template>
  <v-form ref="form" class="pa-4">
    <v-text-field
      v-model="authModel.corporation.name"
      label="Company Name"
      required
      :error-messages="errors['corporation.name']"
    ></v-text-field>
    <v-text-field
      v-model="authModel.corporation.email"
      label="Company Email"
      type="email"
      required
      :error-messages="errors['corporation.email']"
    ></v-text-field>
    <v-text-field
      v-model="authModel.corporation.zip"
      label="Zip"
      required
      :error-messages="errors['corporation.zip']"
    ></v-text-field>
    <v-text-field
      v-model="authModel.corporation.address"
      label="Address"
      required
      :error-messages="errors['corporation.address']"
    ></v-text-field>
    <v-text-field
      v-model="authModel.corporation.phone_number"
      label="TEL"
      required
      :error-messages="errors['corporation.phone_number']"
    ></v-text-field>
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
  </v-form>
</template>

<script>
import { mapMutations, mapActions } from 'vuex'

export default {
  name: 'CorporationForm',
  data() {
    return {
      authModel: {
        corporation: {
          name: '',
          email: '',
          zip: '',
          address: '',
          phone_number: '',
        },
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      errors: {
        corporation: {},
      },
      showPassword: false,
    }
  },
  methods: {
    ...mapMutations('authentication', ['pageLoading']),
    ...mapActions('authentication', ['registerCorporation', 'sendMessage']),
    async register() {
      try {
        await this.registerCorporation(this.authModel)

        this.sendMessage({
          greeting: 'We have sent you an approval email.',
          greetingType: 'success',
        })
      } catch (error) {
        const errors = error.response.data.errors
        const _errors = {}
        for (const key in errors) {
          _errors[key] = errors[key][0]
        }
        this.errors = _errors
        this.pageLoading(false)
      }
    },
  },
}
</script>
