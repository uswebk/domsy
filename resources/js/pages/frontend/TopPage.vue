<template>
  <v-app>
    <v-progress-linear
      v-show="pageLoading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <v-container style="padding: 0" fill-height fluid>
      <v-row style="height: 100%; padding: 0">
        <v-col
          cols="5"
          class="d-flex align-center"
          style="background-color: #e8c46a; position: relative"
        >
          <v-img src="/image/domsy.jpg"></v-img>
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
            <v-col v-if="finishedLoginCheck">
              <login-card></login-card>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import LoginCard from '../../components/top/LoginCard'

export default {
  components: {
    LoginCard,
  },
  computed: {
    ...mapGetters('auth', ['pageLoading', 'finishedLoginCheck']),
  },

  methods: {
    ...mapActions('auth', ['checkLogin']),
  },

  created() {
    this.checkLogin()
  },
}
</script>

<style scoped>
.app__container_row {
  background-color: #efefef;
}
.row__img_row_box {
  background-color: #e8c46a;
  border-top-right-radius: 40px;
  border-bottom-right-radius: 40px;
}
</style>
