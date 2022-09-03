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
      <v-card flat max-width="640" class="mx-auto pa-10" elevation="2" outlined>
        <v-card-title class="text-center pa-6">
          <h3 class="fill-width text-center">Register</h3>
        </v-card-title>
        <v-tabs v-model="tab">
          <v-tab href="#individual">
            <v-icon dark left>mdi-account-box </v-icon>Individual
          </v-tab>
          <v-tab href="#corporation">
            <v-icon dark left>mdi-domain </v-icon>Corporation
          </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
          <v-tab-item value="individual">
            <register-individual-form></register-individual-form>
          </v-tab-item>
          <v-tab-item value="corporation">
            <register-corporation-form></register-corporation-form>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'RegisterPage',
  data() {
    return {
      tab: '',
    }
  },
  computed: {
    ...mapGetters('authentication', [
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
  },
}
</script>
