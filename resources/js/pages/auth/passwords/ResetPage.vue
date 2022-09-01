<template>
  <v-app>
    <v-progress-linear
      v-show="pageLoading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <greeting-message
      :type="greetingType"
      :message="greeting"
    ></greeting-message>
    <v-container>
      <v-card flat max-width="640" class="mx-auto" elevation="2" outlined>
        <v-card-title class="text-center pa-8">
          <h4 class="fill-width">Reset Password</h4>
        </v-card-title>
        <v-form ref="form" class="pa-10">
          <v-text-field :value="email" label="Email" disabled></v-text-field>
          <validation-error-message
            :message="errors.email"
          ></validation-error-message>
          <v-text-field
            v-model="password"
            type="password"
            name="password"
            label="Password"
            hint="At least 8 characters"
            counter
            required
          ></v-text-field>
          <validation-error-message
            :message="errors.password"
          ></validation-error-message>
          <v-text-field
            v-model="password_confirmation"
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
          <v-btn class="mr-4" color="primary" @click="reset()">
            Reset Password
          </v-btn>
        </v-form>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from 'vuex'
import GreetingMessage from '../../../components/common/GreetingMessage'
import ValidationErrorMessage from '../../../components/form/ValidationErrorMessage'

export default {
  components: {
    GreetingMessage,
    ValidationErrorMessage,
  },
  props: {
    token: {
      type: String,
      required: true,
    },
    email: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      greeting: '',
      greetingType: '',
      password: '',
      password_confirmation: '',
      errors: {},
    }
  },
  computed: {
    ...mapGetters('auth', ['pageLoading']),
  },
  methods: {
    ...mapMutations('auth', {
      pageLoadingCommit: 'pageLoading',
    }),
    ...mapActions('auth', ['resetPassword']),

    async reset() {
      try {
        await this.resetPassword({
          token: this.token,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        })

        this.greeting = 'Password reset is complete'
        this.greetingType = 'success'

        setTimeout("location.href='/login'", 1000)
      } catch (error) {
        const errors = error.response.data.errors
        const _errors = {}
        for (let key in errors) {
          _errors[key] = errors[key][0]
        }
        this.errors = _errors

        this.pageLoadingCommit(false)
      }
    },
  },
}
</script>
