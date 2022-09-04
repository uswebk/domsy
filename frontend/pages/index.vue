<template>
  <v-container style="padding: 0" fill-height fluid>
    <v-progress-linear
      v-show="pageLoading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <v-row style="height: 100%; padding: 0">
      <v-col
        cols="5"
        class="d-flex align-center"
        style="background-color: #e8c46a; position: relative"
      >
        <v-img src="/images/domsy.jpg"></v-img>
        <v-fab-transition>
          <v-btn
            fab
            bottom
            right
            absolute
            style="bottom: 50px"
            elevation="1"
            href="https://github.com/uswebk/domsy"
            small
          >
            <v-icon>mdi-github</v-icon>
          </v-btn>
        </v-fab-transition>
      </v-col>
      <v-col cols="7" justify="center" align-self="center">
        <v-row>
          <v-row>
            <v-col v-if="finishedLoginCheck">
              <top-login-card></top-login-card>
            </v-col>
          </v-row>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'IndexPage',
  authenticated: false,
  computed: {
    ...mapGetters('authentication', ['pageLoading', 'finishedLoginCheck']),
  },
  mounted() {
    this.checkLogin()
  },
  methods: {
    ...mapActions('authentication', ['checkLogin']),
  },
}
</script>
