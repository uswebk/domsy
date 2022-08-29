<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6">Account Create</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  class="mt-5"
                  label="Name"
                  v-model="accountModel.name"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.name"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Email"
                  v-model="accountModel.email"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.email"
                ></validation-error-message>

                <v-select
                  class="mt-5"
                  v-model="accountModel.role_id"
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
                  v-model="accountModel.password"
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
                  v-model="accountModel.password_confirmation"
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
import { mapGetters, mapActions } from 'vuex'
import ValidationErrorMessage from '../form/ValidationErrorMessage'

export default {
  name: 'AccountNewDialog',
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
      loading: false,
      accountModel: {
        name: '',
        email: '',
        role_id: null,
        password: '',
        password_confirmation: '',
      },
      errors: {},
    }
  },

  computed: {
    ...mapGetters('role', ['roles']),

    open: {
      get() {
        return this.isOpen
      },
      set() {
        this.errors = {}
        this.close()
      },
    },
  },

  methods: {
    ...mapActions('account', ['storeAccount', 'sendMessage']),

    close() {
      this.$emit('close')
    },

    resetForm() {
      this.accountModel = {
        name: '',
        email: '',
        role_id: null,
        password: '',
        password_confirmation: '',
      }
    },

    async store() {
      try {
        this.loading = true

        await this.storeAccount(this.accountModel)

        this.close()

        this.loading = false

        this.sendMessage({
          greeting: 'Account Create Success',
          greetingType: 'success',
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
        }

        if (status >= 500) {
          message = 'Server Error'
        }

        this.sendMessage({
          greeting: message,
          greetingType: 'error',
        })

        this.close()
      }

      this.resetForm()
    },
  },
}
</script>
