<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-database</v-icon> Domain
      </h1>

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
        @click="openNewModal"
      >
        <v-icon dark left> mdi-plus-circle </v-icon>New
      </v-btn>

      <v-tabs v-model="tab">
        <v-tab href="#active">Active</v-tab>
        <v-tab href="#inActive">InActive</v-tab>
        <v-tab href="#transferred">Transferred</v-tab>
        <v-tab href="#managementOnly">ManagementOnly</v-tab>
      </v-tabs>
      <v-container class="py-1"></v-container>
      <v-tabs-items v-model="tab">
        <div v-for="(_domain, index) in domains" :key="_domain.id">
          <v-tab-item :value="index">
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Price</th>
                    <th class="text-center">Active</th>
                    <th class="text-left">Purchased<br />Date</th>
                    <th class="text-left">Expired<br />Date</th>
                    <th class="text-left">Canceled<br />Date</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="domain in _domain" :key="domain.id">
                    <td>{{ domain.name }}</td>
                    <td>{{ formattedPrice(domain.price) }}</td>
                    <td class="text-center">
                      <span v-if="domain.is_active"
                        ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
                      >
                    </td>
                    <td>{{ formattedDate(domain.purchased_at) }}</td>
                    <td>{{ formattedDate(domain.expired_at) }}</td>
                    <td>{{ formattedDate(domain.canceled_at) }}</td>
                    <td>
                      <v-btn
                        v-if="canUpdate"
                        x-small
                        color="primary"
                        @click="edit(domain)"
                        >edit</v-btn
                      >
                      <v-btn
                        v-if="canDelete"
                        x-small
                        @click="deleteDomain(domain)"
                        >delete</v-btn
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
        :domain="domain"
        @close="closeEditModal"
        @sendMessage="sendMessage"
      ></update-dialog>

      <delete-dialog
        :isOpen="deleteDialog"
        :domain="domain"
        @close="closeDeleteModal"
        @sendMessage="sendMessage"
      ></delete-dialog>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import { shortHyphenDate } from '../../modules/DateHelper'
import { priceFormat } from '../../modules/AppHelper'

import NewDialog from '../../components/domain/NewDialog'
import UpdateDialog from '../../components/domain/UpdateDialog'
import DeleteDialog from '../../components/domain/DeleteDialog'

export default {
  components: {
    NewDialog,
    UpdateDialog,
    DeleteDialog,
  },

  data() {
    return {
      greeting: '',
      alert: '',
      finishInitialize: false,
      tab: '',
      canStore: false,
      canUpdate: false,
      canDelete: false,
      domains: {
        active: {},
        inActive: {},
        managementOnly: {},
        transferred: {},
      },
      domain: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
    }
  },

  methods: {
    async openNewModal() {
      this.newDialog = true
    },

    async openEditModal() {
      this.editDialog = true
    },

    openDeleteModal() {
      this.deleteDialog = true
    },

    closeNewModal() {
      this.newDialog = false
    },

    closeEditModal() {
      this.editDialog = false
    },

    closeDeleteModal() {
      this.deleteDialog = false
    },

    resetGreeting() {
      this.greeting = ''
      this.alert = ''
    },

    sendMessage(result) {
      this.resetGreeting()

      this.initDomains()

      if (result.status === 200) {
        this.greeting = result.message
      } else {
        this.alert = result.message
      }
    },

    async initDomains() {
      this.finishInitialize = false

      const result = await axios.get('/api/domains')

      let activeDomains = []
      let inActiveDomains = []
      let managementOnlyDomains = []
      let transferredDomains = []

      for (let key in result.data) {
        let domain = result.data[key]

        if (domain.is_transferred) {
          transferredDomains.push(domain)
        }

        if (domain.is_management_only) {
          managementOnlyDomains.push(domain)
        }

        if (domain.is_active) {
          activeDomains.push(domain)
        } else {
          inActiveDomains.push(domain)
        }
      }

      this.domains.active = activeDomains
      this.domains.transferred = transferredDomains
      this.domains.inActive = inActiveDomains
      this.domains.managementOnly = managementOnlyDomains

      this.finishInitialize = true
    },

    edit(domain) {
      this.domain.id = domain.id
      this.domain.name = domain.name
      this.domain.price = domain.price
      this.domain.registrarId = domain.registrar_id
      this.domain.isActive = domain.is_active
      this.domain.isTransferred = domain.is_transferred
      this.domain.isManagementOnly = domain.is_management_only
      this.domain.purchasedAt = this.formattedDate(domain.purchased_at)
      this.domain.expiredAt = this.formattedDate(domain.expired_at)
      this.domain.canceledAt = this.formattedDate(domain.canceled_at)

      this.openEditModal()
    },

    async deleteDomain(domain) {
      this.domain = domain

      this.openDeleteModal()
    },

    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },

    formattedPrice(price) {
      return priceFormat(price)
    },

    async canStoreCheck() {
      this.finishInitialize = false

      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.domains.store'
      )
      this.canStore = canStoreResult.data
    },

    async canUpdateCheck() {
      this.finishInitialize = false

      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.domains.update'
      )
      this.canUpdate = canUpdateResult.data
    },

    async canDeleteCheck() {
      this.finishInitialize = false

      let canDeleteResult = await axios.get(
        '/api/roles/user/?has=api.domains.delete'
      )
      this.canDelete = canDeleteResult.data
    },
  },

  async created() {
    this.canStoreCheck()
    this.canUpdateCheck()
    this.canDeleteCheck()

    await this.initDomains()

    this.finishInitialize = true
  },
}
</script>
