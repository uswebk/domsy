<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6">DNS Create</span>
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
                  v-model="prefix"
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
                  v-model="domainId"
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
                  v-model="dnsRecordTypeId"
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
                  v-model="value"
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
                  v-model="ttl"
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
                  v-model="priority"
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
import axios from 'axios'
import ValidationErrorMessage from '../form/ValidationErrorMessage'

export default {
  name: 'NewDialog',
  components: {
    ValidationErrorMessage,
  },
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
      prefix: '',
      dnsRecordTypeId: '',
      value: '',
      ttl: 0,
      priority: 0,
      errors: {},
    }
  },

  computed: {
    domainId: {
      get() {
        return this.domain.id
      },
      set(value) {
        this.$emit('change', value)
      },
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
    resetSubdomain() {
      this.prefix = ''
      this.dnsRecordTypeId = ''
      this.domainId = ''
      this.value = ''
      this.ttl = 0
      this.priority = 0
    },

    async store() {
      try {
        const result = await axios.post('/api/dns', {
          prefix: this.prefix,
          domain_id: this.domainId,
          type_id: this.dnsRecordTypeId,
          value: this.value,
          ttl: this.ttl,
          priority: this.priority,
        })

        this.close()

        this.$emit('sendMessage', {
          message: 'Create success',
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

      this.resetSubdomain()
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
