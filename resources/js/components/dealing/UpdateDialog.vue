<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6"> Dealing Edit</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-select
                  v-model="dealingModel.domain_id"
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
                  v-model="dealingModel.client_id"
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
                  v-model="dealingModel.billing_date"
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
                  v-model="dealingModel.interval_category"
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
                  v-model="dealingModel.is_auto_update"
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
                  v-model="dealingModel.is_halt"
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
import { mapActions, mapGetters } from 'vuex'
import ValidationErrorMessage from '../form/ValidationErrorMessage'

export default {
  name: 'DealingUpdateDialog',
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
      loading: false,
      errors: {},
    }
  },

  computed: {
    ...mapGetters('domain', ['domains']),
    ...mapGetters('client', ['clients']),
    ...mapGetters('dealing', ['pageLoading', 'intervalCategories']),

    dealingModel() {
      return this.dealing
    },
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
    ...mapActions('dealing', ['updateDealing', 'sendMessage']),

    close() {
      this.$emit('close')
    },

    async update() {
      try {
        this.loading = true

        await this.updateDealing(this.dealingModel)

        this.close()

        this.loading = false

        this.sendMessage({
          greeting: 'Update Success',
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
    },
  },
}
</script>
