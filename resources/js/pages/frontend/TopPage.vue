<template>
  <v-app>
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
              href="https://github.com/uswebk/"
              small
            >
              <v-icon>mdi-github</v-icon>
            </v-btn>
          </v-fab-transition>
        </v-col>

        <v-col cols="7" justify="center" align-self="center">
          <v-row>
            <v-col>
              <v-btn v-if="isLogin" color="primary" href="/dashboard">
                <v-icon dark left> mdi-monitor-dashboard </v-icon>Dashboard
              </v-btn>

              <v-card
                flat
                max-width="640"
                class="mx-auto"
                elevation="2"
                outlined
                style="position: relative"
                v-if="!isLogin"
              >
                <v-form ref="form" class="pa-10">
                  <v-text-field
                    v-model="email"
                    label="Email"
                    required
                  ></v-text-field>
                  <p
                    class="red--text"
                    v-text="errors.email"
                    v-if="errors.email"
                  ></p>
                  <v-text-field
                    v-model="password"
                    type="password"
                    name="password"
                    label="Password"
                    hint="At least 8 characters"
                    counter
                    required
                  ></v-text-field>
                  <p
                    class="red--text"
                    v-text="errors.password"
                    v-if="errors.password"
                  ></p>
                  <div class="form-group">
                    <label>
                      <input type="checkbox" v-model="remember" /> Remember Me
                    </label>
                  </div>
                  <div class="my-5"></div>
                  <v-btn class="mr-4" color="primary" @click="login">
                    <v-icon dark left> mdi-login-variant </v-icon>Login
                  </v-btn>
                  <a href="password/reset">Forgot Your Password?</a>
                </v-form>
                <v-divider></v-divider>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      absolute
                      fab
                      bottom
                      right
                      color="primary"
                      style="bottom: -20px"
                      href="/register"
                      v-bind="attrs"
                      v-on="on"
                    >
                      <v-icon>mdi-account-plus</v-icon>
                    </v-btn>
                  </template>
                  <span>Register</span>
                </v-tooltip>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      email: '',
      password: '',
      remember: false,
      errors: {},
    }
  },

  props: {
    isLogin: {
      type: Boolean,
    },
  },

  methods: {
    async login() {
      try {
        const result = await axios.post('api/login', {
          email: this.email,
          password: this.password,
          remember: this.remember,
        })

        if (result.status === 200) {
          location.href = '/dashboard'
        }
      } catch (error) {
        var responseErrors = error.response.data.errors
        var errors = {}

        for (var key in responseErrors) {
          errors[key] = responseErrors[key][0]
        }

        this.errors = errors
      }
    },
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
