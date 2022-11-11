<template>
  <v-app>
    <v-progress-linear
      v-show="pageLoading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <v-snackbar v-model="snackbarModel" :color="greetingType">
      {{ greeting }}
      <template #action="{ attrs }">
        <v-btn color="white" text v-bind="attrs" @click="close"> Close </v-btn>
      </template>
    </v-snackbar>
    <v-container style="width: 550px" class="pa-4">
      <v-row>
        <v-col>
          <p class="text-body-2">
            <nuxt-link to="/register"> ← </nuxt-link>
          </p>
        </v-col>
      </v-row>
      <v-card flat max-width="550" class="mx-auto pa-10" elevation="2" outlined>
        <v-card-title class="text-center pa-6">
          <v-icon>mdi-domain</v-icon>&nbsp;Corporation Register
        </v-card-title>
        <register-corporation-form></register-corporation-form>
        <v-divider></v-divider>
        <v-container>
          <v-row class="d-flex" align-content="center" justify="center">
            <v-col md="8" align="center">
              <v-img
                src="/images/google.png"
                width="180px"
                style="cursor: pointer"
                @click="pushGoogleLogin"
              ></v-img>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'CorporationPage',
  data() {
    return {
      snackbar: true,
    }
  },
  computed: {
    ...mapGetters('authentication', [
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
    snackbarModel() {
      return this.greeting.length > 0 && this.snackbar
    },
  },
  methods: {
    ...mapActions('authentication', ['providerLogin']),
    async pushGoogleLogin() {
      const response = await this.providerLogin('google')
      location.href = response.data
    },
    close() {
      this.snackbar = false
    },
  },
}
</script>
