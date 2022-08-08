<template>
  <div>
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
                    v-model="name"
                    hide-details
                    required
                  ></v-text-field>
                  <validation-error-message-component
                    :message="errors.name"
                  ></validation-error-message-component>

                  <v-select
                    class="mt-5"
                    v-model="registrarId"
                    :items="registrars"
                    item-text="name"
                    item-value="id"
                    label="Registrar"
                    hide-details
                  ></v-select>
                  <validation-error-message-component
                    :message="errors.registrar_id"
                  ></validation-error-message-component>

                  <v-text-field
                    class="mt-5"
                    label="Price"
                    v-model="price"
                    type="number"
                    prefix="¥"
                    required
                    hide-details
                  ></v-text-field>
                  <validation-error-message-component
                    :message="errors.price"
                  ></validation-error-message-component>

                  <v-text-field
                    class="mt-5"
                    label="Purchased Date"
                    v-model="purchasedAt"
                    type="date"
                    required
                    hide-details
                  ></v-text-field>
                  <validation-error-message-component
                    :message="errors.purchased_at"
                  ></validation-error-message-component>

                  <v-text-field
                    class="mt-5"
                    label="Expired Date"
                    v-model="expiredAt"
                    type="date"
                    required
                    hide-details
                  ></v-text-field>
                  <validation-error-message-component
                    :message="errors.expired_at"
                  ></validation-error-message-component>

                  <v-text-field
                    class="mt-5"
                    label="Canceled Date"
                    v-model="canceledAt"
                    type="date"
                    hide-details
                  ></v-text-field>
                  <validation-error-message-component
                    :message="errors.canceled_at"
                  ></validation-error-message-component>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    class="mt-5"
                    v-model="isActive"
                    label="isActive"
                    hide-details
                  ></v-checkbox>
                  <validation-error-message-component
                    :message="errors.is_active"
                  ></validation-error-message-component>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    class="mt-5"
                    v-model="isTransferred"
                    label="isTransferred"
                    hide-details
                  ></v-checkbox>
                  <validation-error-message-component
                    :message="errors.is_transferred"
                  ></validation-error-message-component>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    class="mt-5"
                    v-model="isManagementOnly"
                    label="isManagementOnly"
                    hide-details
                  ></v-checkbox>
                  <validation-error-message-component
                    :message="errors.is_management_only"
                  ></validation-error-message-component>
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
  </div>
</template>

<script>
import axios from 'axios'
import ValidationErrorMessageComponent from '../form/ValidationErrorMessageComponent'

export default {
  components: {
    ValidationErrorMessageComponent,
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
      name: '',
      registrarId: '',
      price: 0,
      isActive: true,
      isTransferred: false,
      isManagementOnly: false,
      purchasedAt: '',
      expiredAt: '',
      canceledAt: '',
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
    resetNewDomain() {
      this.name = ''
      this.registrarId = ''
      this.price = 0
      this.isActive = true
      this.isTransferred = ''
      this.isManagementOnly = ''
      this.purchasedAt = ''
      this.expiredAt = ''
      this.canceledAt = ''
    },

    async store() {
      try {
        await axios.post('/api/domains', {
          name: this.name,
          registrar_id: this.registrarId,
          price: this.price,
          is_active: this.isActive,
          is_transferred: this.isTransferred,
          is_management_only: this.isManagementOnly,
          purchased_at: this.purchasedAt,
          expired_at: this.expiredAt,
          canceled_at: this.canceledAt,
        })

        this.close()

        this.$emit('store', {
          message: 'Create success',
          status: 200,
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

        this.$emit('store', {
          message: message,
          status: status,
        })
      }

      this.resetNewDomain()
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
