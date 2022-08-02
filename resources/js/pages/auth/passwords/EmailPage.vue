<template>
  <v-app>
    <v-alert dense text type="success" v-if="greetingMessage"
      >{{ greetingMessage }}
    </v-alert>
    <v-alert dense text type="error" v-if="errorMessage">{{
      errorMessage
    }}</v-alert>

    <v-container>
      <v-card flat max-width="640" class="mx-auto" elevation="2" outlined>
        <v-card-title class="text-center pa-8">
          <h4 class="fill-width">
            <v-icon middle>mdi-email-sync</v-icon> Reset Password
          </h4>
        </v-card-title>
        <v-form ref="form" class="pa-10">
          <v-text-field v-model="email" label="Email" required></v-text-field>
          <p class="red--text" v-text="errorMessage" v-if="errorMessage"></p>

          <div class="my-5"></div>
          <v-btn class="mr-4" color="primary" @click="sendResetLink">
            Send Password Reset Link
          </v-btn>
        </v-form>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      greetingMessage: '',
      errorMessage: '',
      email: '',
    }
  },

  methods: {
    async sendResetLink() {
      try {
        await axios.post('/password/email', {
          email: this.email,
        })

        this.greetingMessage =
          'Sent a password reset link to  your email address.'
      } catch (error) {
        this.errorMessage = 'Failed to send email'
      }
    },
  },
}
</script>
