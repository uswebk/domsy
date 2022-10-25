<template>
  <v-container style="padding: 0" fill-height fluid>
    <common-greeting-message
      :type="greetingType"
      :message="greeting"
    ></common-greeting-message>
    <v-dialog v-model="open" hide-overlay persistent max-width="400">
      <v-card color="primary" dark>
        <v-card-text align="center" class="pa-5">
          Google login in progress...<br /><br />
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: 'GoogleCallbackPage',
  authenticated: false,
  data() {
    return {
      open: false,
      greeting: '',
      greetingType: '',
    }
  },
  computed: {},
  async mounted() {
    const payload = {
      name: 'google',
      params: this.$route.query,
    }
    try {
      this.open = true
      await this.providerCallback(payload)
      location.href = '/mypage'
    } catch (error) {
      this.greeting = 'Failed to Google Login'
      this.greetingType = 'errors'
    }
    this.open = false
  },
  methods: {
    ...mapActions('authentication', ['providerCallback']),
  },
}
</script>
