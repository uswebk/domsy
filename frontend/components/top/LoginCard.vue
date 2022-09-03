<template>
  <div>
    <v-btn v-if="isLogin" color="primary" href="/mypage">
      <v-icon dark left> mdi-account-box </v-icon>Mypage
    </v-btn>
    <v-card
      v-if="!isLogin"
      flat
      max-width="640"
      class="mx-auto"
      elevation="2"
      outlined
      style="position: relative"
    >
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
        <v-btn class="mr-4" color="primary" @click="login">
          <v-icon dark left> mdi-login-variant </v-icon>Login
        </v-btn>
        <a href="password/email">Forgot Your Password?</a>
      </v-form>
      <v-divider></v-divider>
      <v-tooltip bottom>
        <template #activator="{ on, attrs }">
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
import { mapGetters, mapMutations, mapActions } from 'vuex'

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
    ...mapGetters('authentication', ['isLogin']),
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
        const errors = error.response.data.errors
        const _errors = {}
        for (const key in errors) {
          _errors[key] = errors[key][0]
        }
        this.errors = _errors
        this.pageLoadingCommit(false)
      }
    },
  },
}
</script>
