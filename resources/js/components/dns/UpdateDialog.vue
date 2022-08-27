<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6"> DNS Edit</span>
      </v-card-title>
      <v-card-text>
        <v-container v-if="!loading">
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="3">
                <v-text-field
                  class="mt-5"
                  label="Prefix"
                  v-model="subdomainModel.prefix"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.prefix"
                ></validation-error-message>
              </v-col>
              <v-col cols="9">
                <v-select
                  class="mt-5"
                  v-model="subdomainModel.domain_id"
                  :items="domains"
                  item-text="name"
                  item-value="id"
                  label="Domain"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.domain_id"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-select
                  class="mt-5"
                  v-model="subdomainModel.type_id"
                  :items="dnsRecordTypes"
                  item-text="name"
                  item-value="id"
                  label="DnsType"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.type_id"
                ></validation-error-message>
              </v-col>
              <v-col cols="9">
                <v-text-field
                  class="mt-5"
                  label="Value"
                  v-model="subdomainModel.value"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.value"
                ></validation-error-message>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  class="mt-5"
                  label="TTL"
                  v-model="subdomainModel.ttl"
                  type="number"
                  min="0"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.ttl"
                ></validation-error-message>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  class="mt-5"
                  label="Priority"
                  v-model="subdomainModel.priority"
                  type="number"
                  min="0"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.priority"
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
    subdomain: {
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
    ...mapGetters('dns', ['pageLoading', 'dnsRecordTypes']),

    subdomainModel() {
      return this.subdomain
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
    ...mapActions('dns', ['updateDns', 'sendMessage']),

    close() {
      this.$emit('close')
    },

    async update() {
      try {
        this.updateDns(this.subdomain)

        this.close()

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
