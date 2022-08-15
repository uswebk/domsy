<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6"> DNS Edit</span>
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
              <v-col cols="3">
                <v-text-field
                  class="mt-5"
                  label="Prefix"
                  v-model="subdomainInfo.prefix"
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
                  v-model="subdomainInfo.domain_id"
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
                  v-model="subdomainInfo.type_id"
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
                  v-model="subdomainInfo.value"
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
                  v-model="subdomainInfo.ttl"
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
                  v-model="subdomainInfo.priority"
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
    subdomain: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      loading: true,
      errors: {},
    }
  },

  computed: {
    subdomainInfo() {
      return this.subdomain
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
        const result = await axios.put('/api/dns/' + this.subdomainInfo.id, {
          prefix: this.subdomainInfo.prefix,
          domain_id: this.subdomainInfo.domain_id,
          type_id: this.subdomainInfo.type_id,
          value: this.subdomainInfo.value,
          ttl: this.subdomainInfo.ttl,
          priority: this.subdomainInfo.priority,
        })

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

    const dnsRecordType = await axios.get('/api/dns-record-type')

    this.dnsRecordTypes = dnsRecordType.data

    this.loading = false
  },
}
</script>
