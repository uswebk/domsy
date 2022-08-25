<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6">Domain Create</span>
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
                  label="Common Name"
                  v-model="domainModel.name"
                  hide-details
                  required
                ></v-text-field>
                <validation-error-message
                  :message="errors.name"
                ></validation-error-message>

                <v-select
                  class="mt-5"
                  v-model="domainModel.registrar_id"
                  :items="registrars"
                  item-text="name"
                  item-value="id"
                  label="Registrar"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.registrar_id"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Price"
                  v-model="domainModel.price"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.price"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Purchased Date"
                  v-model="domainModel.purchased_at"
                  type="date"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.purchased_at"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Expired Date"
                  v-model="domainModel.expired_at"
                  type="date"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.expired_at"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Canceled Date"
                  v-model="domainModel.canceled_at"
                  type="date"
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.canceled_at"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="domainModel.is_active"
                  label="isActive"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_active"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="domainModel.is_transferred"
                  label="isTransferred"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_transferred"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="domainModel.is_management_only"
                  label="isManagementOnly"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_management_only"
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
import { mapActions } from 'vuex'
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
      registrars: {},
      domainModel: {
        name: '',
        registrar_id: '',
        price: 0,
        is_active: true,
        is_transferred: false,
        is_management_only: false,
        purchased_at: '',
        expired_at: '',
        canceled_at: '',
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
    ...mapActions('domain', ['storeDomain', 'sendMessage']),

    resetNewDomain() {
      this.domainModel = {
        name: '',
        registrar_id: '',
        price: 0,
        is_active: true,
        is_transferred: false,
        is_management_only: false,
        purchased_at: '',
        expired_at: '',
        canceled_at: '',
      }
    },

    async store() {
      try {
        await this.storeDomain(this.domainModel)

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
          greetingType: 'alert',
        })

        this.close()
      }

      this.resetNewDomain()
    },

    async initRegistrars() {
      const result = await axios.get('/api/registrars')

      this.registrars = result.data
    },

    close() {
      this.$emit('close')
    },
  },
  async created() {
    this.loading = true

    await this.initRegistrars()

    this.loading = false
  },
}
</script>
