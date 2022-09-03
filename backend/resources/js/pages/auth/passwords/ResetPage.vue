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
          <v-text-field
            label="Email"
            :value="email"
            disabled
            :error-messages="errors.email"
          ></v-text-field>
          <v-text-field
            label="Password"
            v-model="password"
            name="password"
            hint="At least 8 characters"
            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            :type="showPassword ? 'text' : 'password'"
            counter
            required
            @click:append="showPassword = !showPassword"
            :error-messages="errors.password"
          ></v-text-field>
          <v-text-field
            label="Confirm Password"
            v-model="password_confirmation"
            type="password"
            name="password_confirmation"
            counter
            required
            :error-messages="errors.password_confirmation"
          ></v-text-field>
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

export default {
  components: {
    GreetingMessage,
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
      showPassword: false,
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
