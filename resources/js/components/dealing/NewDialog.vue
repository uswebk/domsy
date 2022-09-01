<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6">Dealing Create</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-select
                  label="Domain"
                  v-model="dealingModel.domain_id"
                  :items="domains"
                  item-text="name"
                  item-value="id"
                  :error-messages="errors.domain_id"
                ></v-select>
                <v-select
                  label="Client"
                  v-model="dealingModel.client_id"
                  :items="clients"
                  item-text="name"
                  item-value="id"
                  :error-messages="errors.client_id"
                ></v-select>
                <v-text-field
                  label="Amount"
                  v-model="dealingModel.subtotal"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  :error-messages="errors.subtotal"
                ></v-text-field>
                <v-text-field
                  label="Discount"
                  v-model="dealingModel.discount"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  :error-messages="errors.discount"
                ></v-text-field>
                <v-text-field
                  class="mt-5"
                  label="Billing Date"
                  v-model="dealingModel.billing_date"
                  type="date"
                  required
                  :error-messages="errors.billing_date"
                ></v-text-field>
              </v-col>
              <v-col cols="2">
                <v-text-field
                  label="Interval"
                  v-model="dealingModel.interval"
                  type="number"
                  min="0"
                  required
                  :error-messages="errors.interval"
                ></v-text-field>
              </v-col>
              <v-col cols="4">
                <v-select
                  label="IntervalCategory"
                  v-model="dealingModel.interval_category"
                  :items="intervalCategories"
                  :error-messages="errors.interval_category"
                ></v-select>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  label="AutoUpdate"
                  v-model="dealingModel.is_auto_update"
                  :error-messages="errors.is_auto_update"
                ></v-checkbox>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  label="Halt"
                  v-model="dealingModel.is_halt"
                  :error-messages="errors.is_halt"
                ></v-checkbox>
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

export default {
  name: 'DealingNewDialog',
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
      dealingModel: {
        domain_id: '',
        client_id: '',
        subtotal: 0,
        discount: 0,
        billing_date: '',
        interval: '',
        interval_category: '',
        is_auto_update: true,
        is_halt: false,
      },
      errors: {},
    }
  },
  computed: {
    ...mapGetters('domain', ['domains']),
    ...mapGetters('client', ['clients']),
    ...mapGetters('dealing', ['pageLoading', 'intervalCategories']),

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
    ...mapActions('dealing', ['storeDealing', 'sendMessage']),

    close() {
      this.$emit('close')
    },

    resetForm() {
      this.dealingModel = {
        domain_id: '',
        client_id: '',
        subtotal: 0,
        discount: 0,
        billing_date: '',
        interval: '',
        interval_category: '',
        is_auto_update: true,
        is_halt: false,
      }
    },

    async store() {
      this.loading = true
      try {
        this.storeDealing(this.dealingModel)

        this.sendMessage({
          greeting: 'Create Success',
          greetingType: 'success',
        })
      } catch (error) {
        const status = error.response.status

        if (status === 422) {
          const errors = error.response.data.errors
          const _errors = {}
          for (let key in errors) {
            _errors[key] = errors[key][0]
          }
          this.errors = _errors
          this.loading = false
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
      }
      this.close()
      this.resetForm()
      this.loading = false
    },
  },
}
</script>
