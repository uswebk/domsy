<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6">Client Create</span>
      </v-card-title>
      <v-card-text>
        <v-container>
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
                  label="NameKana"
                  v-model="nameKana"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.name_kana"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="email"
                  v-model="email"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.email"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Zip"
                  v-model="zip"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.zip"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Address"
                  v-model="address"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.address"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="TEL"
                  v-model="phoneNumber"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.phone_number"
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
      name: '',
      nameKana: '',
      email: '',
      zip: '',
      address: '',
      phoneNumber: '',
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
    resetClient() {
      this.name = ''
      this.nameKana = ''
      this.email = ''
      this.zip = ''
      this.address = ''
      this.phoneNumber = ''
    },

    async store() {
      try {
        const result = await axios.post('/api/clients', {
          name: this.name,
          name_kana: this.nameKana,
          email: this.email,
          zip: this.zip,
          address: this.address,
          phone_number: this.phoneNumber,
        })

        this.close()

        this.$emit('sendMessage', {
          message: 'Create success',
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

      this.resetClient()
    },

    close() {
      this.open = false
    },
  },
}
</script>
