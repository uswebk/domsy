<template>
  <div>
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
          v-model="authModel.email"
          label="Email"
          required
        ></v-text-field>
        <p class="red--text" v-text="errors.email" v-if="errors.email"></p>
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
          class="red--text"
          v-text="errors.password"
          v-if="errors.password"
        ></p>
        <div class="form-group">
          <label>
            <input type="checkbox" v-model="authModel.remember" /> Remember Me
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
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'LoginCard',
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
    ...mapGetters('auth', ['isLogin', 'completeLoginCheck']),
  },
  methods: {
    ...mapActions('auth', { loginAction: 'login' }),

    async login() {
      try {
        const result = await this.loginAction(this.authModel)

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
    },
  },
}
</script>
