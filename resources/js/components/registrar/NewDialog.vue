<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6">Registrar Create</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  class="mt-5"
                  label="Name"
                  v-model="registrarModel.name"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.name"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Link"
                  v-model="registrarModel.link"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.link"
                ></validation-error-message>

                <v-textarea
                  class="mt-5"
                  label="Note"
                  v-model="registrarModel.note"
                  required
                  hide-details
                ></v-textarea>
                <validation-error-message
                  :message="errors.note"
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
import { mapActions } from 'vuex'

import ValidationErrorMessage from '../form/ValidationErrorMessage'

export default {
  name: 'RegistrarNewDialog',
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
      registrarModel: {
        name: '',
        link: '',
        note: '',
      },
      errors: {},
    }
  },

  computed: {
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
    ...mapActions('registrar', ['storeRegistrar', 'sendMessage']),

    resetRegistrar() {
      this.registrarModel = {
        name: '',
        link: '',
        note: '',
      }
    },

    async store() {
      try {
        await this.storeRegistrar(this.registrarModel)

        this.close()

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
          greetingType: 'error',
        })

        this.close()
      }

      this.resetRegistrar()
    },

    close() {
      this.$emit('close')
    },
  },
}
</script>
