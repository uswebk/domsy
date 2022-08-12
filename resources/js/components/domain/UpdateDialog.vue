<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6">Domain Edit</span>
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
                  v-model="domainInfo.name"
                  hide-details
                  required
                ></v-text-field>
                <validation-error-message
                  :message="errors.name"
                ></validation-error-message>
                <v-select
                  class="mt-5"
                  v-model="domainInfo.registrarId"
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
                  v-model="domainInfo.price"
                  type="number"
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
                  v-model="domainInfo.purchasedAt"
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
                  v-model="domainInfo.expiredAt"
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
                  v-model="domainInfo.canceledAt"
                  type="date"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.canceled_at"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="domainInfo.isActive"
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
                  v-model="domainInfo.isTransferred"
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
                  v-model="domainInfo.isManagementOnly"
                  label="isManagementOnly"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_management_only"
                ></validation-error-message>
              </v-col>
            </v-row>

            <div class="my-5"></div>

            <v-btn color="primary" @click="update">Update</v-btn>
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
  name: 'UpdateDialog',
  components: {
    ValidationErrorMessage,
  },
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    domain: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      loading: true,
      registrars: {},
      errors: {},
    }
  },

  computed: {
    domainInfo() {
      return this.domain
    },
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
    async update() {
      try {
        const result = await axios.put('/api/domains/' + this.domainInfo.id, {
          name: this.domainInfo.name,
          registrar_id: this.domainInfo.registrarId,
          price: this.domainInfo.price,
          is_active: this.domainInfo.isActive,
          is_transferred: this.domainInfo.isTransferred,
          is_management_only: this.domainInfo.isManagementOnly,
          purchased_at: this.domainInfo.purchasedAt,
          expired_at: this.domainInfo.expiredAt,
          canceled_at: this.domainInfo.canceledAt,
        })

        this.close()

        this.$emit('sendMessage', {
          message: 'Update success',
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
    },

    async initRegistrars() {
      const result = await axios.get('/api/registrars')

      this.registrars = result.data
    },

    close() {
      this.open = false
    },
  },

  async created() {
    this.loading = true

    await this.initRegistrars()

    this.loading = false
  },
}
</script>
