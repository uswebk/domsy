<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-web</v-icon> DNS
      </h1>

      <div class="py-5"></div>
      <v-alert dense text dismissible type="success" v-if="greeting">{{
        greeting
      }}</v-alert>
      <v-alert dense text dismissible type="error" v-if="alert">{{
        alert
      }}</v-alert>

      <div v-for="_dns in dns" :key="_dns.id" class="mb-4">
        <v-card>
          <v-card-title>{{ _dns.name }}</v-card-title>
          <v-btn class="ma-2" color="primary" small @click="openNewModal(_dns)">
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>

          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">Name</th>
                  <th class="text-left">Type</th>
                  <th class="text-left">Value</th>
                  <th class="text-left">TTL</th>
                  <th class="text-left">Priority</th>
                  <th class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="subdomain in _dns.subdomains" :key="subdomain.id">
                  <td>{{ subdomain.full_domain }}</td>
                  <td>{{ subdomain.dns_record_name }}</td>
                  <td>{{ subdomain.value }}</td>
                  <td>{{ subdomain.ttl }}</td>
                  <td>{{ subdomain.priority }}</td>
                  <td>
                    <v-btn x-small color="primary" @click="edit(subdomain)"
                      >edit</v-btn
                    >
                    <v-btn x-small @click="deleteSubDomain(subdomain)"
                      >delete</v-btn
                    >
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card>
      </div>

      <!-- New Dialog -->
      <v-dialog v-model="newDialog" max-width="600px">
        <v-card>
          <v-card-title class="pl-8">
            <span class="text-h6">DNS Create</span>
          </v-card-title>
          <v-card-text>
            <v-container>
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
                    <ValidationErrorMessageComponent
                      :message="storeErrors.prefix"
                    />
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
                    <ValidationErrorMessageComponent
                      :message="storeErrors.domain_id"
                    />
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
                    <ValidationErrorMessageComponent
                      :message="storeErrors.type_id"
                    />
                  </v-col>
                  <v-col cols="9">
                    <v-text-field
                      class="mt-5"
                      label="Value"
                      v-model="value"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.value"
                    />
                  </v-col>
                  <v-col cols="6">
                    <v-text-field
                      class="mt-5"
                      label="TTL"
                      v-model="ttl"
                      type="number"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.ttl"
                    />
                  </v-col>
                  <v-col cols="6">
                    <v-text-field
                      class="mt-5"
                      label="Priority"
                      v-model="priority"
                      type="number"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.priority"
                    />
                  </v-col>
                </v-row>

                <div class="my-5"></div>

                <v-btn color="primary" @click="store">Create</v-btn>
              </v-form>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeNewModal">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Update Dialog -->
      <v-dialog v-model="editDialog" max-width="600px">
        <v-card>
          <v-card-title class="pl-8">
            <span class="text-h6"> DNS Edit</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="3">
                    <v-text-field
                      class="mt-5"
                      label="Prefix"
                      v-model="subdomain.prefix"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.prefix"
                    />
                  </v-col>
                  <v-col cols="9">
                    <v-select
                      class="mt-5"
                      v-model="subdomain.domainId"
                      :items="domains"
                      item-text="name"
                      item-value="id"
                      label="Domain"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.domain_id"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-select
                      class="mt-5"
                      v-model="subdomain.typeId"
                      :items="dnsRecordTypes"
                      item-text="name"
                      item-value="id"
                      label="DnsType"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.type_id"
                    />
                  </v-col>
                  <v-col cols="9">
                    <v-text-field
                      class="mt-5"
                      label="Value"
                      v-model="subdomain.value"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.value"
                    />
                  </v-col>
                  <v-col cols="6">
                    <v-text-field
                      class="mt-5"
                      label="TTL"
                      v-model="subdomain.ttl"
                      type="number"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.ttl"
                    />
                  </v-col>
                  <v-col cols="6">
                    <v-text-field
                      class="mt-5"
                      label="Priority"
                      v-model="subdomain.priority"
                      type="number"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.priority"
                    />
                  </v-col>
                </v-row>

                <div class="my-5"></div>

                <v-btn color="primary" @click="update">Update</v-btn>
              </v-form>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeEditModal">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Delete Dialog -->
      <v-dialog v-model="deleteDialog" max-width="290">
        <v-card>
          <v-card-title class="text-h5"> Deletion confirmation </v-card-title>

          <v-card-text>
            Do you want to delete the 「{{ subdomain.full_domain }}」 ?
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="gray darken-1" text @click="closeDeleteModal">
              Close
            </v-btn>

            <v-btn color="red darken-1" text @click="deleteExecute">
              Delete
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import { shortHyphenDate } from '../../modules/DateHelper'
import ValidationErrorMessageComponent from '../../components/form/ValidationErrorMessageComponent'

export default {
  components: {
    ValidationErrorMessageComponent,
  },

  data() {
    return {
      greeting: '',
      alert: '',
      dns: {},
      newDns: {},
      domains: {},
      dnsRecordTypes: {},
      domain: {},
      registrars: {},
      subdomain: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
      prefix: '',
      dnsRecordTypeId: '',
      domainId: '',
      value: '',
      ttl: 0,
      priority: 0,
      storeErrors: {},
      updateErrors: {},
    }
  },

  methods: {
    async openNewModal(domain) {
      await this.initDomains()
      await this.initDnsRecordType()

      this.newDns = domain
      this.domainId = domain.id

      this.newDialog = true
    },

    async openEditModal() {
      this.editDialog = true
    },

    openDeleteModal() {
      this.deleteDialog = true
    },

    closeNewModal() {
      this.resetStoreError()
      this.newDialog = false
    },

    closeEditModal() {
      this.resetUpdateError()
      this.editDialog = false
    },

    closeDeleteModal() {
      this.deleteDialog = false
    },

    resetNewDns() {
      this.prefix = ''
      this.dnsRecordTypeId = ''
      this.domainId = ''
      this.value = ''
      this.ttl = ''
      this.priority = ''
    },

    resetGreeting() {
      this.greeting = ''
      this.alert = ''
    },

    resetStoreError() {
      this.storeErrors = {}
    },

    resetUpdateError() {
      this.updateErrors = {}
    },

    async store() {
      this.resetGreeting()

      try {
        const result = await axios.post('/api/dns', {
          prefix: this.prefix,
          domain_id: this.domainId,
          type_id: this.dnsRecordTypeId,
          value: this.value,
          ttl: this.ttl,
          priority: this.priority,
        })

        if (result.status === 200) {
          this.greeting = 'Create success'
        }

        this.initDns()
        this.closeNewModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeNewModal()
        }

        if (status === 422) {
          var responseErrors = error.response.data.errors
          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.storeErrors = errors
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeNewModal()
        }
      }

      this.resetNewDns()
    },

    async update() {
      this.resetGreeting()

      try {
        const result = await axios.put('/api/dns/' + this.subdomain.id, {
          prefix: this.subdomain.prefix,
          domain_id: this.subdomain.domainId,
          type_id: this.subdomain.typeId,
          value: this.subdomain.value,
          ttl: this.subdomain.ttl,
          priority: this.subdomain.priority,
        })

        if (result.status === 200) {
          this.greeting = 'Update success'
        }
        this.initDns()
        this.closeEditModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeEditModal()
        }

        if (status === 422) {
          var responseErrors = error.response.data.errors

          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.updateErrors = errors
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeEditModal()
        }
      }
    },

    async deleteExecute() {
      try {
        const result = await axios.delete('/api/dns/' + this.subdomain.id)

        if (result.status === 200) {
          this.greeting = 'Delete success'
        }

        this.initDns()
        this.closeDeleteModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeDeleteModal()
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeDeleteModal()
        }
      }
    },

    async initDns() {
      const result = await axios.get('/api/dns')

      this.dns = result.data
    },

    async initDomains() {
      const result = await axios.get('/api/domains')

      this.domains = result.data
    },

    async initDnsRecordType() {
      const result = await axios.get('/api/dns-record-type')

      this.dnsRecordTypes = result.data
    },

    async edit(subdomain) {
      await this.initDomains()
      await this.initDnsRecordType()

      this.subdomain.id = subdomain.id
      this.subdomain.prefix = subdomain.prefix
      this.subdomain.typeId = subdomain.type_id
      this.subdomain.domainId = subdomain.domain_id
      this.subdomain.value = subdomain.value
      this.subdomain.ttl = subdomain.ttl
      this.subdomain.priority = subdomain.priority

      this.openEditModal()
    },

    async deleteSubDomain(subdomain) {
      this.resetGreeting()

      this.subdomain = subdomain

      this.openDeleteModal()
    },

    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },
  },

  created() {
    this.initDns()
  },
}
</script>
