<template>
  <v-app>
    <v-progress-linear
      v-show="pageLoading"
      indeterminate
      color="yellow darken-2"
    ></v-progress-linear>
    <v-container>
      <v-card flat max-width="640" class="mx-auto" elevation="2" outlined>
        <v-card-title class="text-center pa-8">
          <h4 class="fill-width"><v-icon> mdi-login-variant </v-icon> Login</h4>
        </v-card-title>
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
          <v-btn class="mr-4" color="primary" @click="login"> Login </v-btn>
          <a href="password/reset">Forgot Your Password?</a>
        </v-form>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
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
    ...mapGetters('auth', ['pageLoading']),
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
