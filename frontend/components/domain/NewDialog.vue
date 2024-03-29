<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-toolbar color="primary" dark dense flat>
        <v-card-title class="text-subtitle-2">Domain Create</v-card-title>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="domainModel.name"
                  label="Common Name"
                  required
                  :error-messages="errors.name"
                ></v-text-field>
                <v-autocomplete
                  v-model="domainModel.registrar_id"
                  :items="registrars"
                  item-text="name"
                  item-value="id"
                  label="Registrar"
                  placeholder="Registrar Name"
                  :error-messages="errors.registrar_id"
                >
                </v-autocomplete>
                <v-text-field
                  v-model="domainModel.price"
                  label="Price"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  :error-messages="errors.price"
                ></v-text-field>
                <v-text-field
                  v-model="domainModel.purchased_at"
                  label="Purchased Date"
                  type="date"
                  required
                  :error-messages="errors.purchased_at"
                ></v-text-field>
                <v-text-field
                  v-model="domainModel.expired_at"
                  label="Expired Date"
                  type="date"
                  required
                  :error-messages="errors.expired_at"
                ></v-text-field>
                <v-text-field
                  v-model="domainModel.canceled_at"
                  label="Canceled Date"
                  type="date"
                  :error-messages="errors.canceled_at"
                ></v-text-field>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  v-model="domainModel.is_active"
                  label="isActive"
                  :error-messages="errors.is_active"
                ></v-checkbox>
                <v-checkbox
                  v-model="domainModel.is_fetching_dns"
                  label="isDnsAutoFetch"
                  :error-messages="errors.is_fetching_dns"
                ></v-checkbox>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  v-model="domainModel.is_transferred"
                  label="isTransferred"
                  :error-messages="errors.is_transferred"
                ></v-checkbox>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  v-model="domainModel.is_management_only"
                  label="isManagementOnly"
                  :error-messages="errors.is_management_only"
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
  name: 'DomainNewDialog',
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
      domainModel: {
        name: '',
        registrar_id: '',
        price: 0,
        is_active: true,
        is_transferred: false,
        is_management_only: false,
        is_fetching_dns: true,
        purchased_at: '',
        expired_at: '',
        canceled_at: '',
      },
      errors: {},
    }
  },
  computed: {
    ...mapGetters('domain', ['pageLoading']),
    ...mapGetters('registrar', ['registrars']),
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
    ...mapActions('domain', ['storeDomain', 'sendMessage']),
    close() {
      this.errors = {}
      this.resetForm()
      this.$emit('close')
    },
    resetForm() {
      this.domainModel = {
        name: '',
        registrar_id: '',
        price: 0,
        is_active: true,
        is_transferred: false,
        is_management_only: false,
        is_fetching_dns: true,
        purchased_at: '',
        expired_at: '',
        canceled_at: '',
      }
    },
    async store() {
      this.loading = true
      try {
        await this.storeDomain(this.domainModel)

        this.sendMessage({
          greeting: 'Create Success',
          greetingType: 'success',
        })
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
