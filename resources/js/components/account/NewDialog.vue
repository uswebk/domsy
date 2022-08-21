<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6">Account Create</span>
      </v-card-title>
      <v-card-text>
        <v-progress-linear
          v-if="loading"
          color="info"
          indeterminate
        ></v-progress-linear>
        <v-container v-if="!loading">
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  class="mt-5"
                  label="Name"
                  v-model="name"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.name"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Email"
                  v-model="email"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.email"
                ></validation-error-message>

                <v-select
                  class="mt-5"
                  v-model="roleId"
                  :items="roles"
                  item-text="name"
                  item-value="id"
                  label="Role"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.role_id"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  v-model="password"
                  type="password"
                  name="password"
                  label="Password"
                  hint="At least 8 characters"
                  counter
                  required
                ></v-text-field>
                <validation-error-message
                  :message="errors.password"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  v-model="passwordConfirmation"
                  type="password"
                  name="password_confirmation"
                  label="Confirm Password"
                  counter
                  required
                ></v-text-field>
                <validation-error-message
                  :message="errors.password_confirmation"
                ></validation-error-message>
              </v-col>
            </v-row>

            <div class="my-5"></div>

            <v-btn color="primary" @click="store">Create</v-btn>
          </v-form>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="close"> Close </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios'
import ValidationErrorMessage from '../form/ValidationErrorMessage'

export default {
  name: 'NewDialog',
  components: {
    ValidationErrorMessage,
  },
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {
      loading: true,
      roles: [],
      name: '',
      email: '',
      roleId: null,
      password: '',
      passwordConfirmation: '',
      errors: {},
    }
  },

  computed: {
    open: {
      get() {
        return this.isOpen
      },
      set(value) {
        this.errors = {}

        this.$emit('close', value)
      },
    },
  },

  methods: {
    resetFormData() {
      this.name = ''
      this.email = ''
      this.roleId = ''
      this.password = ''
      this.passwordConfirmation = ''
    },

    async store() {
      try {
        const result = await axios.post('/api/accounts', {
          name: this.name,
          role_id: this.roleId,
          email: this.email,
          password: this.password,
          password_confirmation: this.passwordConfirmation,
        })

        this.close()

        this.$emit('sendMessage', {
          message: 'Create success and Send Verify Mail',
          status: result.status,
        })
      } catch (error) {
        const status = error.response.status

        if (status === 422) {
          var responseErrors = error.response.data.errors
          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.errors = errors
          return
        }

        let message = ''
        if (status === 403) {
          message = 'Illegal operation was performed.'
          this.close()
        }

        if (status >= 500) {
          message = 'Server Error'
          this.close()
        }

        this.$emit('sendMessage', {
          message: message,
          status: status,
        })
      }

      this.resetFormData()
    },

    close() {
      this.open = false
    },

    async initRoles() {
      const result = await axios.get('api/roles')

      this.roles = result.data
    },
  },

  async created() {
    this.loading = true

    this.initRoles()

    this.loading = false
  },
}
</script>
