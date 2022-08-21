<template>
  <v-dialog v-model="open" max-width="300px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6">Billing Edit</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Billing Date"
                  v-model="billingModel.billingDate"
                  type="date"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.billing_date"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Total"
                  v-model="billingModel.total"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.total"
                ></validation-error-message>

                <v-checkbox
                  class="mt-5"
                  v-model="billingModel.isFixed"
                  label="isFixed"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_fixed"
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
  name: 'BillingDialog',
  components: {
    ValidationErrorMessage,
  },

  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    billing: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      errors: {},
    }
  },

  computed: {
    billingModel() {
      return this.billing
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
          '/api/dealings/billings/' + this.billingModel.id,
          {
            billing_date: this.billingModel.billingDate,
            total: this.billingModel.total,
            is_fixed: this.billingModel.isFixed,
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
}
</script>
