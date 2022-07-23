<template>
  <v-app>
    <v-alert dense text type="success" v-if="sendMailMessage"
      >{{ sendMailMessage }}
    </v-alert>
    <v-container>
      <v-card flat max-width="640" class="mx-auto" elevation="2" outlined>
        <v-card-title class="text-center pa-8">
          <h4 class="fill-width">Register</h4>
        </v-card-title>
        <v-form ref="form" class="pa-10">
          <v-text-field v-model="name" label="Name" required></v-text-field>
          <p class="red--text" v-text="errors.name" v-if="errors.name"></p>
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
          <v-text-field
            v-model="passwordConfirmation"
            type="password"
            name="password_confirmation"
            label="Confirm Password"
            counter
            required
          ></v-text-field>
          <p
            class="red--text"
            v-text="errors.password_confirmation"
            v-if="errors.password_confirmation"
          ></p>
          <div class="my-5"></div>
          <v-btn class="mr-4" color="primary" @click="register">
            Register
          </v-btn>
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
      name: '',
      email: '',
      password: '',
      passwordConfirmation: '',
      errors: {},
      sendMailMessage: '',
    }
  },

  methods: {
    async register() {
      try {
        await axios.post('api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.passwordConfirmation,
        })

        this.sendMailMessage = 'We have sent you an approval email.'
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
