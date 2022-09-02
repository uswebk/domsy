<template>
  <div>
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
          <a href="password/reset">Forgot Your Password?</a>
        </v-form>
      </v-card>
    </v-container>
    <v-btn class="mr-4" color="primary" @click="user"> Login </v-btn>
  </div>
</template>

<script>
export default {
  auth: false,
  name: 'LoginPage',
  data() {
    return {
      pageLoading: false,
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
    // ...mapGetters('auth', ['pageLoading']),
  },
  methods: {
    // ...mapActions('auth', { loginAction: 'login' }),

    async login() {
      const result = await this.$axios.post('/api/login', {
        email: this.authModel.email,
        password: this.authModel.password,
        remember: this.authModel.remember,
      })

      // const result = await this.$axios.get('api/me')

      console.log(result)
    },

    async user() {
      const result = await this.$axios.get('/api/user')
      console.log(result.data)
    },
  },
}
</script>
