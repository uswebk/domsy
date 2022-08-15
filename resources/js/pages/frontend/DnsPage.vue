<template>
  <v-main>
    <v-container>
      <icon-head-line :icon="'mdi-web'" :headlineText="'DNS'"></icon-head-line>

      <div class="py-5"></div>

      <greeting-message
        :type="greetingType"
        :message="message"
      ></greeting-message>

      <v-progress-linear
        v-show="!finishInitialize"
        color="yellow darken-2"
        indeterminate
        rounded
        height="6"
      ></v-progress-linear>

      <div v-for="_dns in dns" :key="_dns.id" class="mb-4">
        <v-card>
          <v-card-title>{{ _dns.name }}</v-card-title>
          <v-btn
            v-if="canStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewModal(_dns)"
          >
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
                    <v-btn
                      v-if="canUpdate"
                      x-small
                      color="primary"
                      @click="edit(subdomain)"
                      >edit</v-btn
                    >
                    <v-btn
                      v-if="canDelete"
                      x-small
                      @click="deleteSubDomain(subdomain)"
                      >delete</v-btn
                    >
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card>
      </div>

      <new-dialog
        :isOpen="newDialog"
        :domain="domain"
        @close="closeNewModal"
        @sendMessage="sendMessage"
      ></new-dialog>

      <!-- Update Dialog -->
      <v-dialog v-model="editDialog" max-width="600px">
        <v-card>
          <v-card-title class="pl-8">
            <span class="text-h6"> DNS Edit</span>
          </v-card-title>
          <v-card-text>
            <v-progress-linear
              v-if="dialogLoading"
              color="info"
              indeterminate
            ></v-progress-linear>
            <v-container v-if="!dialogLoading">
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
                    <ValidationErrorMessage :message="updateErrors.prefix" />
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
                    <ValidationErrorMessage :message="updateErrors.domain_id" />
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
                    <ValidationErrorMessage :message="updateErrors.type_id" />
                  </v-col>
                  <v-col cols="9">
                    <v-text-field
                      class="mt-5"
                      label="Value"
                      v-model="subdomain.value"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="updateErrors.value" />
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
                    <ValidationErrorMessage :message="updateErrors.ttl" />
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
                    <ValidationErrorMessage :message="updateErrors.priority" />
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
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import NewDialog from '../../components/dns/NewDialog'

import ValidationErrorMessage from '../../components/form/ValidationErrorMessage'

export default {
  components: {
    ValidationErrorMessage,
    IconHeadLine,
    GreetingMessage,
    NewDialog,
  },

  data() {
    return {
      greetingType: '',
      message: '',
      finishInitialize: false,
      dialogLoading: false,
      canStore: false,
      canUpdate: false,
      canDelete: false,
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
      updateErrors: {},
    }
  },

  methods: {
    async openNewModal(domain) {
      this.dialogLoading = true

      this.newDialog = true
      this.domain = domain

      this.dialogLoading = false
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

    sendMessage(result) {
      this.resetGreeting()

      this.initDns()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
      }
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
      this.finishInitialize = false

      const result = await axios.get('/api/dns')

      this.dns = result.data

      this.finishInitialize = true
    },

    async initDomains() {
      const result = await axios.get('/api/domains')

      this.domains = result.data
    },

    async initDnsRecordType() {
      const result = await axios.get('/api/dns-record-type')

      this.dnsRecordTypes = result.data
    },

    async initRoleOperation() {
      let canStoreResult = await axios.get('/api/roles/user/?has=api.dns.store')
      this.canStore = canStoreResult.data

      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.dns.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDeleteResult = await axios.get(
        '/api/roles/user/?has=api.dns.delete'
      )
      this.canDelete = canDeleteResult.data

      this.finishInitialize = true
    },

    async edit(subdomain) {
      this.dialogLoading = true

      this.openEditModal()

      await this.initDomains()
      await this.initDnsRecordType()

      this.subdomain.id = subdomain.id
      this.subdomain.prefix = subdomain.prefix
      this.subdomain.typeId = subdomain.type_id
      this.subdomain.domainId = subdomain.domain_id
      this.subdomain.value = subdomain.value
      this.subdomain.ttl = subdomain.ttl
      this.subdomain.priority = subdomain.priority

      this.dialogLoading = false
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
    this.initRoleOperation()
  },
}
</script>
