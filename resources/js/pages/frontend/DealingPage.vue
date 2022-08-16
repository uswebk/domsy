<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-note-edit'"
        :headlineText="'Dealing'"
      ></icon-head-line>

      <div class="py-5"></div>
      <v-alert dense text dismissible type="success" v-if="greeting">{{
        greeting
      }}</v-alert>
      <v-alert dense text dismissible type="error" v-if="alert">{{
        alert
      }}</v-alert>

      <v-progress-linear
        v-show="!finishInitialize"
        color="yellow darken-2"
        indeterminate
        rounded
        height="6"
      ></v-progress-linear>

      <v-btn
        v-if="canStore"
        class="ma-2"
        color="primary"
        small
        @click="openNewModal()"
      >
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
                    <td>{{ formattedPrice(dealing.subtotal) }}</td>
                    <td>{{ formattedPrice(dealing.discount) }}</td>
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
                      <v-btn
                        v-if="canUpdate"
                        x-small
                        color="primary"
                        @click="edit(dealing)"
                        >edit</v-btn
                      >
                      <v-btn
                        v-if="canDetail"
                        x-small
                        color="primary"
                        @click="detail(dealing)"
                        >detail</v-btn
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
          <v-card-title class="pl-8">
            <span class="text-h6">Dealing Create</span>
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
                  <v-col cols="12">
                    <v-select
                      v-model="domainId"
                      :items="domains"
                      item-text="name"
                      item-value="id"
                      label="Domain"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessage :message="storeErrors.domain_id" />
                    <v-select
                      class="mt-5"
                      v-model="clientId"
                      :items="clients"
                      item-text="name"
                      item-value="id"
                      label="Client"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessage :message="storeErrors.client_id" />
                    <v-text-field
                      class="mt-5"
                      label="Subtotal"
                      v-model="subtotal"
                      type="number"
                      prefix="¥"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="storeErrors.subtotal" />
                    <v-text-field
                      class="mt-5"
                      label="Discount"
                      v-model="discount"
                      type="number"
                      prefix="¥"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="storeErrors.discount" />
                    <v-text-field
                      class="mt-5"
                      label="Billing Date"
                      v-model="billingDate"
                      type="date"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage
                      :message="storeErrors.billing_date"
                    />
                  </v-col>
                  <v-col cols="2">
                    <v-text-field
                      label="Interval"
                      v-model="interval"
                      type="number"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="storeErrors.interval" />
                  </v-col>
                  <v-col cols="4">
                    <v-select
                      v-model="intervalCategory"
                      :items="intervalCategories"
                      label="IntervalCategory"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessage
                      :message="storeErrors.interval_category"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="isAutoUpdate"
                      label="AutoUpdate"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessage
                      :message="storeErrors.is_auto_update"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="isHalt"
                      label="Halt"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessage :message="storeErrors.is_halt" />
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
            <span class="text-h6"> Dealing Edit</span>
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
                  <v-col cols="12">
                    <v-select
                      v-model="dealing.domainId"
                      :items="domains"
                      item-text="name"
                      item-value="id"
                      label="Domain"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessage :message="updateErrors.domain_id" />
                    <v-select
                      class="mt-5"
                      v-model="dealing.clientId"
                      :items="clients"
                      item-text="name"
                      item-value="id"
                      label="Client"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessage :message="updateErrors.client_id" />
                    <v-text-field
                      class="mt-5"
                      label="Subtotal"
                      v-model="dealing.subtotal"
                      type="number"
                      prefix="¥"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="updateErrors.subtotal" />
                    <v-text-field
                      class="mt-5"
                      label="Discount"
                      v-model="dealing.discount"
                      type="number"
                      prefix="¥"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="updateErrors.discount" />
                    <v-text-field
                      class="mt-5"
                      label="Billing Date"
                      v-model="dealing.billingDate"
                      type="date"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage
                      :message="updateErrors.billing_date"
                    />
                  </v-col>
                  <v-col cols="2">
                    <v-text-field
                      class="mt-5"
                      label="Interval"
                      v-model="dealing.interval"
                      type="number"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="updateErrors.interval" />
                  </v-col>
                  <v-col cols="4">
                    <v-select
                      class="mt-5"
                      v-model="dealing.intervalCategory"
                      :items="intervalCategories"
                      label="IntervalCategory"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessage
                      :message="updateErrors.interval_category"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="dealing.isAutoUpdate"
                      label="AutoUpdate"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessage
                      :message="updateErrors.is_auto_update"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="dealing.isHalt"
                      label="Halt"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessage :message="updateErrors.is_halt" />
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

      <!-- Detail Dialog -->
      <v-dialog
        v-model="detailDialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <v-card>
          <v-toolbar dark color="primary">
            <v-btn icon dark @click="closeDetailModal">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title> Dealing Detail</v-toolbar-title>
          </v-toolbar>
          <v-container>
            <v-card-text>
              <v-list three-line subheader>
                <v-subheader>{{ dealing.domain }}</v-subheader>
                <v-card-title>Billing</v-card-title>

                <div
                  v-for="billing in dealing.domain_billings"
                  :key="billing.id"
                >
                  <v-divider></v-divider>
                  <v-list-item>
                    <v-list-item-content>
                      <v-list-item-title>{{
                        formattedDate(billing.billing_date)
                      }}</v-list-item-title>
                      <v-list-item-subtitle>{{
                        formattedPrice(billing.total)
                      }}</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                      <v-icon
                        v-if="!billing.is_fixed && canBillingUpdate"
                        @click="editBilling(billing)"
                        small
                      >
                        mdi-pencil
                      </v-icon></v-list-item-action
                    >
                  </v-list-item>
                </div>
              </v-list>
              <v-divider></v-divider>
            </v-card-text>
          </v-container>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeDetailModal">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Billing Dialog -->
      <v-dialog v-model="editBillingDialog" max-width="300px">
        <v-card>
          <v-card-title class="pl-8">
            <span class="text-h6">Billing Edit</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Billing Date"
                      v-model="billing.billingDate"
                      type="date"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage
                      :message="updateErrors.billing_date"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Total"
                      v-model="billing.total"
                      type="number"
                      prefix="¥"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="updateErrors.total" />
                    <v-checkbox
                      class="mt-5"
                      v-model="billing.isFixed"
                      label="isFixed"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessage :message="updateErrors.is_fixed" />
                  </v-col>
                </v-row>

                <div class="my-5"></div>

                <v-btn color="primary" @click="updateBilling">Update</v-btn>
              </v-form>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeBillingEditModal">
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
import { priceFormat } from '../../modules/AppHelper'
import IconHeadLine from '../../components/common/IconHeadLine'

import ValidationErrorMessage from '../../components/form/ValidationErrorMessage'

export default {
  components: {
    ValidationErrorMessage,
    IconHeadLine,
  },

  data() {
    return {
      greeting: '',
      alert: '',
      tab: '',
      finishInitialize: false,
      dialogLoading: false,
      canStore: false,
      canUpdate: false,
      canDetail: false,
      canBillingUpdate: false,
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
      billing: {},
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
      detailDialog: false,
      editBillingDialog: false,
    }
  },

  methods: {
    async openNewModal() {
      this.dialogLoading = true
      this.newDialog = true

      await this.initDomains()
      await this.initClients()

      this.dialogLoading = false
    },

    async openEditModal() {
      this.editDialog = true
    },

    async openBillingEditModal() {
      this.editBillingDialog = true
    },

    openDetailModal() {
      this.detailDialog = true
    },

    closeNewModal() {
      this.resetStoreError()
      this.newDialog = false
    },

    closeEditModal() {
      this.resetUpdateError()
      this.editDialog = false
    },

    closeDetailModal() {
      this.detailDialog = false
    },

    async closeBillingEditModal() {
      this.editBillingDialog = false
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
    async updateBilling() {
      this.resetGreeting()

      try {
        const result = await axios.put(
          '/api/dealings/billings/' + this.billing.id,
          {
            billing_date: this.billing.billingDate,
            total: this.billing.total,
            is_fixed: this.billing.isFixed,
          }
        )

        if (result.status === 200) {
          this.greeting = 'Update success'
        }
        this.initDealings()
        this.closeBillingEditModal()
        this.closeDetailModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeBillingEditModal()
          this.closeDetailModal()
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
          this.closeBillingEditModal()
          this.closeDetailModal()
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

    async initRoleOperation() {
      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.dealings.store'
      )
      this.canStore = canStoreResult.data

      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.dealings.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDetailResult = await axios.get(
        '/api/roles/user/?has=api.dealings.detail'
      )
      this.canDetail = canDetailResult.data

      let canBillingUpdateResult = await axios.get(
        '/api/roles/user/?has=api.dealings.updateBilling'
      )
      this.canBillingUpdate = canBillingUpdateResult.data

      this.finishInitialize = true
    },

    async edit(dealing) {
      this.dialogLoading = true

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

      await this.initDomains()
      await this.initClients()

      this.dialogLoading = false
    },

    async detail(dealing) {
      this.dealing = dealing

      this.openDetailModal()
    },

    async editBilling(billing) {
      this.billing.id = billing.id
      this.billing.billingDate = this.formattedDate(billing.billing_date)
      this.billing.total = billing.total
      this.billing.isFixed = billing.is_fixed

      this.openBillingEditModal()
    },

    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },
    formattedPrice(price) {
      return priceFormat(price)
    },
  },

  created() {
    this.initDealings()
    this.initRoleOperation()
  },
}
</script>
