<template>
  <v-app>
    <v-container>
      <v-row class="d-flex m-auto" align-content="center" justify="center">
        <v-col md="6">
          <v-card align="center" class="pb-10">
            <v-img src="/images/domsy.jpg"> </v-img>
            <br />
            <v-btn color="primary" to="/mypage" nuxt> Start Domsy </v-btn>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'VerifyCompletePage',
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
  },
}
</script>
