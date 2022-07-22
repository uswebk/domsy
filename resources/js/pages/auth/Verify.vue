<template>
  <v-app>
    <v-alert dense text type="success" v-if="greetingMessage"
      >{{ greetingMessage }}
    </v-alert>
    <v-alert dense text type="error" v-if="errorMessage">{{
      errorMessage
    }}</v-alert>

    <v-container>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <v-card>
            <v-card-title>Verify Your Email Address</v-card-title>

            <v-card-text>
              Before proceeding, please check your email for a verification
              link. If you did not receive the email
              <a @click="resend"> click here to request another</a>.
            </v-card-text>
          </v-card>
        </div>
      </div>
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
    }
  },

  methods: {
    async resend() {
      try {
        await axios.post('/email/resend', {})

        this.greetingMessage =
          'A fresh verification link has been sent to your email address.'
      } catch (error) {
        this.errorMessage = 'Failed to send email'
      }
    },
  },
}
</script>
