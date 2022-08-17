<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-note-edit'"
        :headlineText="'Dealing'"
      ></icon-head-line>

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

      <new-dialog
        :isOpen="newDialog"
        @close="closeNewModal"
        @sendMessage="sendMessage"
      ></new-dialog>

      <update-dialog
        :isOpen="editDialog"
        :dealing="dealing"
        @close="closeEditModal"
        @sendMessage="sendMessage"
      ></update-dialog>

      <detail-dialog
        :isOpen="detailDialog"
        :dealing="dealing"
        @close="closeDetailModal"
        @sendMessage="sendMessage"
      ></detail-dialog>

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
import GreetingMessage from '../../components/common/GreetingMessage'

import NewDialog from '../../components/dealing/NewDialog'
import UpdateDialog from '../../components/dealing/UpdateDialog'
import DetailDialog from '../../components/dealing/DetailDialog'

import ValidationErrorMessage from '../../components/form/ValidationErrorMessage'

export default {
  components: {
    ValidationErrorMessage,
    IconHeadLine,
    GreetingMessage,
    NewDialog,
    UpdateDialog,
    DetailDialog,
  },

  data() {
    return {
      greetingType: '',
      message: '',
      tab: '',
      finishInitialize: false,
      dialogLoading: false,
      canStore: false,
      canUpdate: false,
      canDetail: false,
      dealings: {
        active: {},
        stop: {},
      },
      dealing: {},
      domains: {},
      clients: {},
      domain: {},
      billing: {},
      newDialog: false,
      storeErrors: {},
      updateErrors: {},
      editDialog: false,
      detailDialog: false,
      editBillingDialog: false,
    }
  },

  methods: {
    async openNewModal() {
      this.newDialog = true
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

    resetGreeting() {
      this.greetingType = ''
      this.message = ''
    },

    resetUpdateError() {
      this.updateErrors = {}
    },

    sendMessage(result) {
      this.resetGreeting()

      this.initDealings()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
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
      this.finishInitialize = false

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

      this.finishInitialize = true
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
