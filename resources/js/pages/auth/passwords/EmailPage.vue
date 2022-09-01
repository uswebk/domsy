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
          <h4 class="fill-width">
            <v-icon middle>mdi-email-sync</v-icon> Reset Password
          </h4>
        </v-card-title>
        <v-form ref="form" class="pa-10">
          <v-text-field v-model="email" label="Email" required></v-text-field>
          <div class="my-5"></div>
          <v-btn class="mr-4" color="primary" @click="send">
            Send Password Reset Link
          </v-btn>
        </v-form>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import GreetingMessage from '../../../components/common/GreetingMessage'

export default {
  components: {
    GreetingMessage,
  },
  data() {
    return {
      greeting: '',
      greetingType: '',
      email: '',
    }
  },
  computed: {
    ...mapGetters('auth', ['pageLoading']),
  },
  methods: {
    ...mapActions('auth', ['sendResetLink']),

    async send() {
      try {
        await this.sendResetLink(this.email)

        this.greeting = 'Sent a password reset link to  your email address.'
        this.greetingType = 'success'
      } catch (error) {
        this.errorMessage = 'Failed to send email'
        this.greetingType = 'errors'
      }
    },
  },
}
</script>
