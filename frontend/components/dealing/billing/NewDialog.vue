<template>
  <v-dialog v-model="open" max-width="300px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-toolbar color="primary" dark dense flat>Billing Create</v-toolbar>
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
            <v-btn color="primary" @click="update">Create</v-btn>
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
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'BillingNewDialog',
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
      billingModel: {
        dealing_id: '',
        billing_date: '',
        total: 0,
        is_fixed: false,
        is_auto: false,
        changed_at: null,
      },

      errors: {},
    }
  },
  computed: {
    ...mapGetters('dealing', ['dealing']),
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
    ...mapActions('dealing', ['fetchDealing', 'storeBilling']),
    close() {
      this.$emit('close')
    },
    async update() {
      this.loading = true
      try {
        this.billingModel.dealing_id = this.dealing.id
        const result = await this.storeBilling(this.billingModel)
        await this.fetchDealing(result.data.dealing.id)

        alert('create success')
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
