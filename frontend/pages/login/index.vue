<template>
  <v-app>
    <v-progress-linear
      v-show="pageLoading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <v-container style="width: 550px" class="pa-4">
      <v-row>
        <v-col>
          <p class="text-body-2">
            <nuxt-link to="/"> ← Top </nuxt-link>
          </p>
        </v-col>
      </v-row>
      <v-card flat max-width="550" class="mx-auto" elevation="2" outlined>
        <v-card-title class="text-center pa-8">
          <h4 class="fill-width"><v-icon> mdi-login-variant </v-icon> Login</h4>
        </v-card-title>
        <v-form ref="form" class="pa-10">
          <v-text-field
            v-model="authModel.email"
            label="Email"
            required
          ></v-text-field>
          <p v-if="errors.email" class="red--text" v-text="errors.email"></p>
          <v-text-field
            v-model="authModel.password"
            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            :type="showPassword ? 'text' : 'password'"
            name="password"
            label="Password"
            hint="At least 8 characters"
            counter
            @click:append="showPassword = !showPassword"
          ></v-text-field>
          <p
            v-if="errors.password"
            class="red--text"
            v-text="errors.password"
          ></p>
          <div class="form-group">
            <label>
              <input v-model="authModel.remember" type="checkbox" /> Remember Me
            </label>
          </div>
          <div class="my-5"></div>
          <v-btn class="mr-4" color="primary" @click="login"> Login </v-btn>
          <nuxt-link to="password/email">Forgot Your Password?</nuxt-link>
        </v-form>
        <v-divider></v-divider>
        <v-container>
          <v-row class="d-flex" align-content="center" justify="center">
            <v-col md="5" align="center">
              <v-img
                src="/images/google.png"
                width="180px"
                style="cursor: pointer"
                @click="pushGoogleLogin"
              ></v-img>
            </v-col>
          </v-row>
        </v-container>
        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn
              absolute
              fab
              bottom
              right
              color="primary"
              style="bottom: -20px"
              to="/register"
              v-bind="attrs"
              nuxt
              v-on="on"
            >
              <v-icon>mdi-account-plus</v-icon>
            </v-btn>
          </template>
          <span>Register</span>
        </v-tooltip>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from 'vuex'

export default {
  name: 'LoginPage',
  data() {
    return {
      authModel: {
        email: '',
        password: '',
        remember: false,
      },
      errors: {},
      showPassword: false,
    }
  },
  computed: {
    ...mapGetters('authentication', ['pageLoading']),
  },
  methods: {
    ...mapMutations('authentication', {
      pageLoadingCommit: 'pageLoading',
    }),
    ...mapActions('authentication', {
      loginAction: 'login',
      providerLogin: 'providerLogin',
    }),
    async login() {
      try {
        const result = await this.loginAction(this.authModel)

        if (result.status === 200 || result.status === 204) {
          location.href = '/mypage'
        }
      } catch (error) {
        const responseErrors = error.response.data.errors
        const errors = {}
        for (const key in responseErrors) {
          errors[key] = responseErrors[key][0]
        }
        this.errors = errors
      }
      this.pageLoadingCommit(false)
    },
    async pushGoogleLogin() {
      const response = await this.providerLogin('google')
      location.href = response.data
    },
  },
}
</script>
