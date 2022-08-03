<template>
  <v-app>
    <v-container>
      <v-card flat max-width="640" class="mx-auto" elevation="2" outlined>
        <v-card-title class="text-center pa-8">
          <h4 class="fill-width"><v-icon> mdi-login-variant </v-icon> Login</h4>
        </v-card-title>
        <v-form ref="form" class="pa-10">
          <v-text-field v-model="email" label="Email" required></v-text-field>
          <p class="red--text" v-text="errors.email" v-if="errors.email"></p>
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
          <v-btn class="mr-4" color="primary" @click="login"> Login </v-btn>
          <a href="password/reset">Forgot Your Password?</a>
        </v-form>
      </v-card>
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

  methods: {
    async login() {
      try {
        await axios.post('api/login', {
          email: this.email,
          password: this.password,
          remember: this.remember,
        })

        location.href = '/mypage'
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
