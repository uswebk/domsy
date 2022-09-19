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
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="3">
                <v-text-field
                  v-model="subdomainModel.prefix"
                  label="Prefix"
                  required
                  :error-messages="errors.prefix"
                ></v-text-field>
              </v-col>
              <v-col cols="9">
                <v-autocomplete
                  v-model="subdomainModel.domain_id"
                  label="Domain"
                  :items="domains"
                  item-text="name"
                  item-value="id"
                  placeholder="Domain Name"
                  :error-messages="errors.domain_id"
                ></v-autocomplete>
              </v-col>
              <v-col cols="3">
                <v-select
                  v-model="subdomainModel.type_id"
                  label="DnsType"
                  :items="dnsRecordTypes"
                  item-text="name"
                  item-value="id"
                  :error-messages="errors.type_id"
                ></v-select>
              </v-col>
              <v-col cols="9">
                <v-text-field
                  v-model="subdomainModel.value"
                  label="Value"
                  required
                  :error-messages="errors.value"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  v-model="subdomainModel.ttl"
                  label="TTL"
                  type="number"
                  min="0"
                  required
                  :error-messages="errors.ttl"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  v-model="subdomainModel.priority"
                  label="Priority"
                  type="number"
                  min="0"
                  required
                  :error-messages="errors.priority"
                ></v-text-field>
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
  name: 'DnsUpdateDialog',
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
        this.close()
      },
    },
  },
  methods: {
    ...mapActions('dns', ['updateDns', 'sendMessage']),
    close() {
      this.errors = {}
      this.$emit('close')
    },
    async update() {
      this.loading = true
      try {
        await this.updateDns(this.subdomain)

        this.sendMessage({
          greeting: 'Update Success',
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
    },
  },
}
</script>
