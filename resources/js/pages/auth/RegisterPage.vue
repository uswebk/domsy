<template>
  <v-app>
    <v-alert dense text type="success" v-if="sendMailMessage"
      >{{ sendMailMessage }}
    </v-alert>
    <v-container>
      <v-card flat max-width="640" class="mx-auto pa-10" elevation="2" outlined>
        <v-card-title class="text-center pa-6">
          <h3 class="fill-width text-center">Register</h3>
        </v-card-title>

        <v-tabs v-model="tab">
          <v-tab href="#individual"
            ><v-icon dark left>mdi-account-box </v-icon>Individual</v-tab
          >
          <v-tab href="#corporation"
            ><v-icon dark left>mdi-domain </v-icon>Corporation</v-tab
          >
        </v-tabs>
        <v-tabs-items v-model="tab">
          <v-tab-item value="individual">
            <v-form ref="form" class="pa-4">
              <v-text-field
                class="mb-5"
                v-model="name"
                label="Name"
                required
                hide-details
              ></v-text-field>
              <ValidationErrorMessageComponent :message="errors.name" />
              <v-text-field
                class="mb-5"
                v-model="email"
                label="Email"
                required
                hide-details
              ></v-text-field>
              <ValidationErrorMessageComponent :message="errors.email" />
              <v-text-field
                v-model="password"
                type="password"
                name="password"
                label="Password"
                hint="At least 8 characters"
                counter
                required
              ></v-text-field>
              <ValidationErrorMessageComponent :message="errors.password" />
              <v-text-field
                v-model="passwordConfirmation"
                type="password"
                name="password_confirmation"
                label="Confirm Password"
                counter
                required
              ></v-text-field>
              <ValidationErrorMessageComponent
                :message="errors.password_confirmation"
              />
              <div class="my-5"></div>
              <v-btn class="mr-4" color="primary" @click="register">
                Register
              </v-btn>
            </v-form>
          </v-tab-item>
          <v-tab-item value="corporation">
            <v-form ref="form" class="pa-4">
              <v-text-field
                class="mb-5"
                v-model="companyName"
                label="Company Name"
                required
                hide-details
              ></v-text-field>
              <ValidationErrorMessageComponent :message="companyErrors.name" />

              <v-text-field
                class="mb-5"
                v-model="companyEmail"
                label="Company Email"
                required
                hide-details
                type="email"
              ></v-text-field>
              <ValidationErrorMessageComponent :message="companyErrors.email" />
              <v-text-field
                class="mb-5"
                v-model="companyZip"
                label="Zip"
                required
                hide-details
              ></v-text-field>
              <ValidationErrorMessageComponent :message="companyErrors.zip" />
              <v-text-field
                class="mb-5"
                v-model="companyAddress"
                label="Address"
                required
                hide-details
              ></v-text-field>
              <ValidationErrorMessageComponent
                :message="companyErrors.address"
              />
              <v-text-field
                class="mb-5"
                v-model="companyPhoneNumber"
                label="TEL"
                required
                hide-details
              ></v-text-field>
              <ValidationErrorMessageComponent
                :message="companyErrors.phone_number"
              />

              <v-text-field
                class="mb-5"
                v-model="name"
                label="Name"
                required
                hide-details
              ></v-text-field>
              <ValidationErrorMessageComponent :message="errors.name" />
              <v-text-field
                class="mb-5"
                v-model="email"
                label="Email"
                required
                hide-details
              ></v-text-field>
              <ValidationErrorMessageComponent :message="errors.email" />

              <v-text-field
                v-model="password"
                type="password"
                name="password"
                label="Password"
                hint="At least 8 characters"
                counter
                required
              ></v-text-field>
              <ValidationErrorMessageComponent :message="errors.password" />
              <v-text-field
                v-model="passwordConfirmation"
                type="password"
                name="password_confirmation"
                label="Confirm Password"
                counter
                required
              ></v-text-field>
              <ValidationErrorMessageComponent
                :message="errors.password_confirmation"
              />
              <div class="my-5"></div>
              <v-btn class="mr-4" color="primary" @click="corporationRegister">
                Register
              </v-btn>
            </v-form>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import axios from 'axios'
import ValidationErrorMessageComponent from '../../components/form/ValidationErrorMessageComponent'

export default {
  components: {
    ValidationErrorMessageComponent,
  },

  data() {
    return {
      tab: '',
      name: '',
      email: '',
      password: '',
      passwordConfirmation: '',
      companyName: '',
      companyEmail: '',
      companyZip: '',
      companyAddress: '',
      companyPhoneNumber: '',
      errors: {},
      companyErrors: {},
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

    async corporationRegister() {
      try {
        await axios.post('api/corporation/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.passwordConfirmation,
          corporation: {
            name: this.companyName,
            email: this.companyEmail,
            zip: this.companyZip,
            address: this.companyAddress,
            phone_number: this.companyPhoneNumber,
          },
        })
        this.sendMailMessage = 'We have sent you an approval email.'
      } catch (error) {
        var responseErrors = error.response.data.errors

        console.log(responseErrors)
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
