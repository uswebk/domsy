<template>
  <v-app>
    <v-container class="grey lighten-5" fill-height fluid>
      <v-row>
        <v-col
          class="row__img_row_box"
          cols="6"
        >
          <v-img src="/image/domsy.jpg"></v-img>
        </v-col>
        <v-col cols="6" justify="center" align-self="center">
          <v-row>
            <v-col>
              <v-btn v-if="isLogin" color="primary" href="/dashboard">
                <v-icon dark left> mdi-monitor-dashboard </v-icon>Dashboard
              </v-btn>
              <v-btn v-if="!isLogin" color="primary" href="/register">
                <v-icon dark left> mdi-account-plus </v-icon>Register
              </v-btn>
              <v-btn v-if="!isLogin" color="primary" href="/login">
                <v-icon dark left> mdi-login-variant </v-icon>Login
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<style scoped>
.row__img_row_box{
  background-color: #e8c46a;
  border-top-right-radius: 40px;
  border-bottom-right-radius: 40px;
}
</style>
<script>
export default {
  props: {
    isLogin: {
      type: Boolean,
    },
  },
}
</script>
