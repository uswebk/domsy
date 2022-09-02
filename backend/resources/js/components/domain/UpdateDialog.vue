<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6">Domain Edit</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Common Name"
                  v-model="domainModel.name"
                  required
                  :error-messages="errors.name"
                ></v-text-field>
                <v-select
                  label="Registrar"
                  v-model="domainModel.registrar_id"
                  :items="registrars"
                  item-text="name"
                  item-value="id"
                  :error-messages="errors.registrar_id"
                ></v-select>
                <v-text-field
                  label="Price"
                  v-model="domainModel.price"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  :error-messages="errors.price"
                ></v-text-field>
                <v-text-field
                  label="Purchased Date"
                  v-model="domainModel.purchased_at"
                  type="date"
                  required
                  :error-messages="errors.purchased_at"
                ></v-text-field>
                <v-text-field
                  label="Expired Date"
                  v-model="domainModel.expired_at"
                  type="date"
                  required
                  :error-messages="errors.expired_at"
                ></v-text-field>
                <v-text-field
                  label="Canceled Date"
                  v-model="domainModel.canceled_at"
                  type="date"
                  required
                  :error-messages="errors.canceled_at"
                ></v-text-field>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  label="isActive"
                  v-model="domainModel.is_active"
                  :error-messages="errors.is_active"
                ></v-checkbox>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  label="isTransferred"
                  v-model="domainModel.is_transferred"
                  :error-messages="errors.is_transferred"
                ></v-checkbox>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  label="isManagementOnly"
                  v-model="domainModel.is_management_only"
                  :error-messages="errors.is_management_only"
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
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'DomainUpdateDialog',
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
      loading: false,
      errors: {},
    }
  },
  computed: {
    ...mapGetters('domain', ['pageLoading']),
    ...mapGetters('registrar', ['registrars']),

    domainModel() {
      return this.domain
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
    ...mapActions('domain', ['updateDomain', 'sendMessage']),

    close() {
      this.errors = {}
      this.$emit('close')
    },

    async update() {
      this.loading = true
      try {
        await this.updateDomain(this.domainModel)

        this.sendMessage({
          greeting: 'Update Success',
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
      this.loading = false
    },
  },
}
</script>
