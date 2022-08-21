<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6"> Dealing Edit</span>
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
                <v-select
                  v-model="dealingModel.domainId"
                  :items="domains"
                  item-text="name"
                  item-value="id"
                  label="Domain"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.domain_id"
                ></validation-error-message>

                <v-select
                  class="mt-5"
                  v-model="dealingModel.clientId"
                  :items="clients"
                  item-text="name"
                  item-value="id"
                  label="Client"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.client_id"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Subtotal"
                  v-model="dealingModel.subtotal"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.subtotal"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Discount"
                  v-model="dealingModel.discount"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.discount"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Billing Date"
                  v-model="dealingModel.billingDate"
                  type="date"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.billing_date"
                ></validation-error-message>
              </v-col>
              <v-col cols="2">
                <v-text-field
                  class="mt-5"
                  label="Interval"
                  v-model="dealingModel.interval"
                  type="number"
                  min="0"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.interval"
                ></validation-error-message>
              </v-col>
              <v-col cols="4">
                <v-select
                  class="mt-5"
                  v-model="dealingModel.intervalCategory"
                  :items="intervalCategories"
                  label="IntervalCategory"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.interval_category"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="dealingModel.isAutoUpdate"
                  label="AutoUpdate"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_auto_update"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="dealingModel.isHalt"
                  label="Halt"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_halt"
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
    dealing: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      loading: true,
      intervalCategories: ['DAY', 'WEEK', 'MONTH', 'YEAR'],
      errors: {},
    }
  },

  computed: {
    dealingModel() {
      return this.dealing
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
        const result = await axios.put(
          '/api/dealings/' + this.dealingModel.id,
          {
            domain_id: this.dealingModel.domainId,
            client_id: this.dealingModel.clientId,
            subtotal: this.dealingModel.subtotal,
            discount: this.dealingModel.discount,
            billing_date: this.dealingModel.billingDate,
            interval: this.dealingModel.interval,
            interval_category: this.dealingModel.intervalCategory,
            is_auto_update: this.dealingModel.isAutoUpdate,
            is_halt: this.dealingModel.isHalt,
          }
        )

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

    close() {
      this.open = false
    },
  },

  async created() {
    this.loading = true

    const domains = await axios.get('/api/domains')

    this.domains = domains.data

    const result = await axios.get('/api/clients')

    this.clients = result.data

    this.loading = false
  },
}
</script>
