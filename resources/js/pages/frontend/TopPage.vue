<template>
  <v-app>
    <v-progress-linear
      v-show="viewProgress"
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
            <v-col v-if="isLoginCheck">
              <v-btn v-if="isLogin" color="primary" href="/mypage">
                <v-icon dark left> mdi-account-box </v-icon>Mypage
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
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    label="Password"
                    hint="At least 8 characters"
                    counter
                    @click:append="showPassword = !showPassword"
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
      showPassword: false,
      isLogin: false,
      isLoginCheck: false,
      viewProgress: false,
    }
  },

  methods: {
    async login() {
      try {
        this.viewProgress = true

        const result = await axios.post('api/login', {
          email: this.email,
          password: this.password,
          remember: this.remember,
        })

        if (result.status === 200 || result.status === 204) {
          location.href = '/mypage'
        }
      } catch (error) {
        var responseErrors = error.response.data.errors
        var errors = {}

        for (var key in responseErrors) {
          errors[key] = responseErrors[key][0]
        }

        this.errors = errors
      }
      this.viewProgress = false
    },

    async initIsLogin() {
      try {
        const result = await axios.get('api/me')
        if (result.status === 200) {
          this.isLogin = true
        }
      } catch (error) {
        this.isLogin = false
      }

      this.isLoginCheck = true
    },
  },

  created() {
    this.initIsLogin()
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
