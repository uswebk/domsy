<template>
  <v-dialog v-model="open" max-width="300px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6">Billing Edit</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="billingModel.billing_date"
                  label="Billing Date"
                  type="date"
                  required
                  :error-messages="errors.billing_date"
                ></v-text-field>
                <v-text-field
                  v-model="billingModel.total"
                  label="Total"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  :error-messages="errors.total"
                ></v-text-field>
                <v-checkbox
                  v-model="billingModel.is_fixed"
                  label="isFixed"
                  :error-messages="errors.is_fixed"
                ></v-checkbox>
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
import { mapActions } from 'vuex'

export default {
  name: 'BillingDialog',
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
      loading: false,
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
      set() {
        this.errors = {}
        this.close()
      },
    },
  },
  methods: {
    ...mapActions('dealing', ['fetchDealing', 'updateBilling']),
    close() {
      this.$emit('close')
    },
    async update() {
      this.loading = true
      try {
        const result = await this.updateBilling(this.billingModel)
        await this.fetchDealing(result.data.dealing.id)

        alert('update success')
      } catch (error) {
        const status = error.response.status

        if (status === 422) {
          const errors = error.response.data.errors
          const _errors = {}
          for (const key in errors) {
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

        alert(message)
      }
      this.loading = false
      this.close()
    },
  },
}
</script>
