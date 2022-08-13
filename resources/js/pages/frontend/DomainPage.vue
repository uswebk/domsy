<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-database'"
        :headlineText="'Domain'"
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
        @click="openNewModal"
      >
        <v-icon dark left> mdi-plus-circle </v-icon>New
      </v-btn>

      <v-tabs v-model="tab">
        <v-tab href="#active">Active</v-tab>
        <v-tab href="#inactive">InActive</v-tab>
        <v-tab href="#transferred">Transferred</v-tab>
        <v-tab href="#managementOnly">ManagementOnly</v-tab>
      </v-tabs>
      <v-container class="py-1"></v-container>
      <v-tabs-items v-model="tab">
        <div v-for="(_domain, index) in domains" :key="_domain.id">
          <v-tab-item :value="index">
            <list-table
              :headers="headers"
              :domains="_domain"
              @edit="edit"
              @delete="deleteDomain"
            ></list-table>
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
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import NewDialog from '../../components/domain/NewDialog'
import UpdateDialog from '../../components/domain/UpdateDialog'
import DeleteDialog from '../../components/domain/DeleteDialog'
import ListTable from '../../components/domain/ListTable'

export default {
  components: {
    NewDialog,
    UpdateDialog,
    DeleteDialog,
    ListTable,
    IconHeadLine,
    GreetingMessage,
  },

  data() {
    return {
      greetingType: '',
      message: '',
      finishInitialize: false,
      tab: '',
      canStore: false,
      domains: {
        active: [],
        inactive: [],
        managementOnly: [],
        transferred: [],
      },
      domain: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,

      headers: [
        {
          text: 'Name',
          value: 'name',
        },
        {
          text: 'Price',
          value: 'price',
        },
        {
          text: 'Active',
          value: 'is_active',
        },
        {
          text: 'Purchased Date',
          value: 'purchased_at',
        },
        {
          text: 'Expired Date',
          value: 'expired_at',
        },
        {
          text: 'Canceled Date',
          value: 'canceled_at',
        },
        {
          text: 'Action',
          value: 'action',
          sortable: false,
        },
      ],
    }
  },

  methods: {
    openNewModal() {
      this.newDialog = true
    },

    openEditModal() {
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
        this.greetingType = 'success'
        this.greeting = result.message
      } else {
        this.greetingType = 'error'
        this.alert = result.message
      }
    },

    async initDomains() {
      this.finishInitialize = false

      const result = await axios.get('/api/domains')

      let activeDomains = []
      let inactiveDomains = []
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
          inactiveDomains.push(domain)
        }
      }

      this.domains.active = activeDomains
      this.domains.transferred = transferredDomains
      this.domains.inactive = inactiveDomains
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

    async canStoreCheck() {
      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.domains.store'
      )
      this.canStore = canStoreResult.data
    },
  },

  async created() {
    await this.canStoreCheck()
    await this.initDomains()
  },
}
</script>
