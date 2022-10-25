<template>
  <v-dialog v-model="open" max-width="290">
    <v-card :loading="loading">
      <v-toolbar color="primary" dark dense flat>
        <v-card-title class="text-h6">Billing Cancel</v-card-title>
      </v-toolbar>
      <v-card-text>
        <v-container>Cancel this billing?</v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="gray darken-1" text @click="close"> Close </v-btn>
        <v-btn color="red darken-1" text @click="cancel"> Cancel </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'BillingCancelDialog',
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
        this.close()
      },
    },
  },
  methods: {
    ...mapActions('dealing', ['fetchDealing', 'cancelBilling']),
    close() {
      this.$emit('close')
    },
    async cancel() {
      this.loading = true
      try {
        const result = await this.cancelBilling(this.billingModel)
        await this.fetchDealing(result.data.dealing.id)

        alert('cancel success')
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
