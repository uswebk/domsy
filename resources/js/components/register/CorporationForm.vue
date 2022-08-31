<template>
  <v-form ref="form" class="pa-4">
    <v-text-field
      class="mb-5"
      v-model="authModel.corporation.name"
      label="Company Name"
      required
      hide-details
    ></v-text-field>
    <validation-error-message
      :message="errors['corporation.name']"
    ></validation-error-message>
    <v-text-field
      class="mb-5"
      v-model="authModel.corporation.email"
      label="Company Email"
      required
      hide-details
      type="email"
    ></v-text-field>
    <validation-error-message
      :message="errors['corporation.email']"
    ></validation-error-message>
    <v-text-field
      class="mb-5"
      v-model="authModel.corporation.zip"
      label="Zip"
      required
      hide-details
    ></v-text-field>
    <validation-error-message
      :message="errors['corporation.zip']"
    ></validation-error-message>
    <v-text-field
      class="mb-5"
      v-model="authModel.corporation.address"
      label="Address"
      required
      hide-details
    ></v-text-field>
    <validation-error-message
      :message="errors['corporation.address']"
    ></validation-error-message>
    <v-text-field
      class="mb-5"
      v-model="authModel.corporation.phone_number"
      label="TEL"
      required
      hide-details
    ></v-text-field>
    <validation-error-message
      :message="errors['corporation.phone_number']"
    ></validation-error-message>
    <v-text-field
      class="mb-5"
      v-model="authModel.name"
      label="Name"
      required
      hide-details
    ></v-text-field>
    <validation-error-message :message="errors.name"></validation-error-message>
    <v-text-field
      class="mb-5"
      v-model="authModel.email"
      label="Email"
      required
      hide-details
    ></v-text-field>
    <validation-error-message
      :message="errors.email"
    ></validation-error-message>
    <v-text-field
      v-model="authModel.password"
      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
      :type="showPassword ? 'text' : 'password'"
      name="password"
      label="Password"
      hint="At least 8 characters"
      counter
      @click:append="showPassword = !showPassword"
    ></v-text-field>
    <validation-error-message
      :message="errors.password"
    ></validation-error-message>
    <v-text-field
      v-model="authModel.password_confirmation"
      type="password"
      name="password_confirmation"
      label="Confirm Password"
      counter
      required
    ></v-text-field>
    <validation-error-message
      :message="errors.password_confirmation"
    ></validation-error-message>
    <div class="my-5"></div>
    <v-btn class="mr-4" color="primary" @click="register"> Register </v-btn>
  </v-form>
</template>

<script>
import { mapMutations, mapActions } from 'vuex'
import ValidationErrorMessage from '../../components/form/ValidationErrorMessage'

export default {
  name: 'CorporationForm',
  components: {
    ValidationErrorMessage,
  },
  props: {
    message: {
      type: String,
    },
  },
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
    ...mapMutations('auth', ['pageLoading']),
    ...mapActions('auth', ['registerCorporation', 'sendMessage']),

    async register() {
      try {
        await this.registerCorporation(this.authModel)

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
