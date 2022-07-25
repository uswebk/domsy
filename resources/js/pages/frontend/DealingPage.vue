<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-note-edit</v-icon> Dealing
      </h1>

      <div class="py-5"></div>
      <v-alert dense text type="success" v-if="greeting">{{
        greeting
      }}</v-alert>
      <v-alert dense text type="error" v-if="alert">{{ alert }}</v-alert>

      <v-btn class="ma-2" color="primary" small @click="openNewModal()">
        <v-icon dark left> mdi-plus-circle </v-icon>New
      </v-btn>

      <v-tabs v-model="tab">
        <v-tab href="#active">Active</v-tab>
        <v-tab href="#stop">Stop</v-tab>
      </v-tabs>
      <v-container class="py-1"></v-container>
      <v-tabs-items v-model="tab">
        <div v-for="(_dealing, index) in dealings" :key="_dealing.id">
          <v-tab-item :value="index">
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Domain Name</th>
                    <th class="text-left">Client Name</th>
                    <th class="text-left">Subtotal</th>
                    <th class="text-left">Discount</th>
                    <th class="text-left">First Billing Date</th>
                    <th class="text-left">Interval</th>
                    <th class="text-center">Auto Update</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="dealing in _dealing" :key="dealing.id">
                    <td>{{ dealing.domain }}</td>
                    <td>{{ dealing.client.name }}</td>
                    <td>{{ dealing.subtotal }}</td>
                    <td>{{ dealing.discount }}</td>
                    <td>{{ formattedDate(dealing.billing_date) }}</td>
                    <td>
                      {{ dealing.interval }} {{ dealing.interval_category }}
                    </td>
                    <td class="text-center">
                      <span v-if="dealing.is_auto_update"
                        ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
                      >
                    </td>
                    <td>
                      <v-btn x-small color="primary" @click="edit(dealing)"
                        >edit</v-btn
                      >
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-tab-item>
        </div>
      </v-tabs-items>

      <!-- New Dialog -->
      <v-dialog v-model="newDialog" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="text-h6">Dealing Create</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-select
                      v-model="domainId"
                      :items="domains"
                      item-text="name"
                      item-value="id"
                      label="Domain"
                    ></v-select>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.domain_id"
                      v-if="storeErrors.domain_id"
                    ></p>
                    <v-select
                      v-model="clientId"
                      :items="clients"
                      item-text="name"
                      item-value="id"
                      label="Client"
                    ></v-select>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.client_id"
                      v-if="storeErrors.client_id"
                    ></p>
                    <v-text-field
                      label="Subtotal"
                      v-model="subtotal"
                      type="number"
                      prefix="¥"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.subtotal"
                      v-if="storeErrors.subtotal"
                    ></p>
                    <v-text-field
                      label="Discount"
                      v-model="discount"
                      type="number"
                      prefix="¥"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.discount"
                      v-if="storeErrors.discount"
                    ></p>
                    <v-text-field
                      label="Billing Date"
                      v-model="billingDate"
                      type="date"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.billing_date"
                      v-if="storeErrors.billing_date"
                    ></p>
                  </v-col>
                  <v-col cols="2">
                    <v-text-field
                      label="Interval"
                      v-model="interval"
                      type="number"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.interval"
                      v-if="storeErrors.interval"
                    ></p>
                  </v-col>
                  <v-col cols="4">
                    <v-select
                      v-model="intervalCategory"
                      :items="intervalCategories"
                      label="IntervalCategory"
                    ></v-select>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.client_id"
                      v-if="storeErrors.client_id"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="isAutoUpdate"
                      label="AutoUpdate"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.is_auto_update"
                      v-if="storeErrors.is_auto_update"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox v-model="isHalt" label="Halt"></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.is_halt"
                      v-if="storeErrors.is_halt"
                    ></p>
                  </v-col>
                </v-row>

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
          <v-card-title>
            <span class="text-h6"> Dealing Edit</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-select
                      v-model="dealing.domainId"
                      :items="domains"
                      item-text="name"
                      item-value="id"
                      label="Domain"
                    ></v-select>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.domain_id"
                      v-if="updateErrors.domain_id"
                    ></p>
                    <v-select
                      v-model="dealing.clientId"
                      :items="clients"
                      item-text="name"
                      item-value="id"
                      label="Client"
                    ></v-select>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.client_id"
                      v-if="updateErrors.client_id"
                    ></p>
                    <v-text-field
                      label="Subtotal"
                      v-model="dealing.subtotal"
                      type="number"
                      prefix="¥"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.subtotal"
                      v-if="updateErrors.subtotal"
                    ></p>
                    <v-text-field
                      label="Discount"
                      v-model="dealing.discount"
                      type="number"
                      prefix="¥"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.discount"
                      v-if="updateErrors.discount"
                    ></p>
                    <v-text-field
                      label="Billing Date"
                      v-model="dealing.billingDate"
                      type="date"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.billing_date"
                      v-if="updateErrors.billing_date"
                    ></p>
                  </v-col>
                  <v-col cols="2">
                    <v-text-field
                      label="Interval"
                      v-model="dealing.interval"
                      type="number"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.interval"
                      v-if="updateErrors.interval"
                    ></p>
                  </v-col>
                  <v-col cols="4">
                    <v-select
                      v-model="dealing.intervalCategory"
                      :items="intervalCategories"
                      label="IntervalCategory"
                    ></v-select>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.client_id"
                      v-if="updateErrors.client_id"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="dealing.isAutoUpdate"
                      label="AutoUpdate"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.is_auto_update"
                      v-if="updateErrors.is_auto_update"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="dealing.isHalt"
                      label="Halt"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.is_halt"
                      v-if="updateErrors.is_halt"
                    ></p>
                  </v-col>
                </v-row>

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
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import { shortHyphenDate } from '../../modules/DateHelper'

export default {
  data() {
    return {
      greeting: '',
      alert: '',
      tab: '',
      dealings: {
        active: {},
        stop: {},
      },
      dealing: {},
      domains: {},
      clients: {},
      dnsRecordTypes: {},
      intervalCategories: ['DAY', 'WEEK', 'MONTH', 'YEAR'],
      domain: {},
      subdomain: {},
      newDialog: false,
      prefix: '',
      dnsRecordTypeId: '',
      domainId: '',
      clientId: '',
      subtotal: 0,
      discount: 0,
      billingDate: '',
      interval: '',
      intervalCategory: '',
      isAutoUpdate: true,
      isHalt: false,
      storeErrors: {},
      updateErrors: {},
      editDialog: false,
      deleteDialog: false,
    }
  },

  methods: {
    async openNewModal() {
      await this.initDomains()
      await this.initClients()

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

    resetNewDealing() {
      this.domainId = ''
      this.clientId = ''
      this.subtotal = 0
      this.discount = 0
      this.billingDate = ''
      this.interval = ''
      this.intervalCategory = ''
      this.isAutoUpdate = true
      this.isHalt = false
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
        const result = await axios.post('/api/dealings', {
          domain_id: this.domainId,
          client_id: this.clientId,
          subtotal: this.subtotal,
          discount: this.discount,
          billing_date: this.billingDate,
          interval: this.interval,
          interval_category: this.intervalCategory,
          is_auto_update: this.isAutoUpdate,
          is_halt: this.isHalt,
        })

        if (result.status === 200) {
          this.greeting = 'Create success'
        }

        this.initDealings()
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

      this.resetNewDealing()
    },

    async update() {
      this.resetGreeting()

      try {
        const result = await axios.put('/api/dealings/' + this.dealing.id, {
          domain_id: this.dealing.domainId,
          client_id: this.dealing.clientId,
          subtotal: this.dealing.subtotal,
          discount: this.dealing.discount,
          billing_date: this.dealing.billingDate,
          interval: this.dealing.interval,
          interval_category: this.dealing.intervalCategory,
          is_auto_update: this.dealing.isAutoUpdate,
          is_halt: this.dealing.isHalt,
        })

        if (result.status === 200) {
          this.greeting = 'Update success'
        }
        this.initDealings()
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

    async initDealings() {
      const result = await axios.get('/api/dealings')

      let dealings_actives = []
      let dealings_stops = []
      for (let key in result.data) {
        for (let key2 in result.data[key].domain_dealings) {
          let dealing = result.data[key].domain_dealings[key2]
          dealing.domain = result.data[key].name

          if (dealing.is_halt) {
            dealings_stops.push(dealing)
          } else {
            dealings_actives.push(dealing)
          }
        }
      }

      this.dealings.active = dealings_actives
      this.dealings.stop = dealings_stops
    },

    async initDomains() {
      const result = await axios.get('/api/domains')

      this.domains = result.data
    },

    async initClients() {
      const result = await axios.get('/api/clients')

      this.clients = result.data
    },

    async edit(dealing) {
      await this.initDomains()
      await this.initClients()

      this.dealing.id = dealing.id
      this.dealing.domainId = dealing.domain_id
      this.dealing.clientId = dealing.client_id
      this.dealing.subtotal = dealing.subtotal
      this.dealing.discount = dealing.discount
      this.dealing.billingDate = this.formattedDate(dealing.billing_date)
      this.dealing.interval = dealing.interval
      this.dealing.intervalCategory = dealing.interval_category
      this.dealing.isAutoUpdate = dealing.is_auto_update
      this.dealing.isHalt = dealing.is_halt

      this.openEditModal()
    },

    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },
  },

  created() {
    this.initDealings()
  },
}
</script>
