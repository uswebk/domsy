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
    ...mapActions('authentication', { loginAction: 'login' }),
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
  },
}
</script>
