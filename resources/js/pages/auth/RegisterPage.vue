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
            <individual-form></individual-form>
          </v-tab-item>
          <v-tab-item value="corporation">
            <corporation-form></corporation-form>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
import GreetingMessage from '../../components/common/GreetingMessage'
import IndividualForm from '../../components/register/IndividualForm'
import CorporationForm from '../../components/register/CorporationForm'

export default {
  components: {
    GreetingMessage,
    IndividualForm,
    CorporationForm,
  },
  data() {
    return {
      tab: '',
    }
  },
  computed: {
    ...mapGetters('auth', ['pageLoading', 'greeting', 'greetingType']),
  },
}
</script>
