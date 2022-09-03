<template>
  <v-app>
    <v-progress-linear
      v-show="pageLoading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <common-greeting-message
      :type="greetingType"
      :message="greeting"
    ></common-greeting-message>
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
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'VerifyPage',
  data() {
    return {
      greeting: '',
      greetingType: '',
    }
  },
  computed: {
    ...mapGetters('authentication', ['pageLoading']),
  },
  methods: {
    ...mapActions('authentication', ['resendEmail']),
    async resend() {
      try {
        await this.resendEmail()

        this.greeting =
          'A fresh verification link has been sent to your email address.'
        this.greetingType = 'success'
      } catch (error) {
        this.errorMessage = 'Failed to send email'
        this.greetingType = 'error'
      }
    },
  },
}
</script>
