<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
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
                  v-model="clientModel.name"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.name"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="NameKana"
                  v-model="clientModel.name_kana"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.name_kana"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="email"
                  v-model="clientModel.email"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.email"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Zip"
                  v-model="clientModel.zip"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.zip"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Address"
                  v-model="clientModel.address"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.address"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="TEL"
                  v-model="clientModel.phone_number"
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
import { mapActions, mapGetters } from 'vuex'
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
      loading: false,
      clientModel: {
        name: '',
        name_kana: '',
        email: '',
        zip: '',
        address: '',
        phone_number: '',
      },
      errors: {},
    }
  },

  computed: {
    ...mapGetters('client', ['pageLoading']),
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
    ...mapActions('client', ['storeClient', 'sendMessage']),
    resetClient() {
      this.clientModel = {
        name: '',
        name_kana: '',
        email: '',
        zip: '',
        address: '',
        phone_number: '',
      }
    },

    async store() {
      try {
        this.loading = true

        await this.storeClient(this.clientModel)

        this.close()

        this.loading = false

        this.sendMessage({
          greeting: 'Create Success',
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
          greetingType: 'alert',
        })

        this.close()
      }

      this.resetClient()
    },

    close() {
      this.$emit('close')
    },
  },
}
</script>
