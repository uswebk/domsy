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

          <list-table
            :headers="headers"
            :subdomains="_dns.subdomains"
            @edit="edit"
            @delete="deleteSubDomain"
          ></list-table>
        </v-card>
      </div>

      <new-dialog
        :isOpen="newDialog"
        :domain="domain"
        @close="closeNewModal"
        @change="changeDomainId"
        @sendMessage="sendMessage"
      ></new-dialog>

      <update-dialog
        :isOpen="editDialog"
        :subdomain="subdomain"
        @close="closeEditModal"
        @sendMessage="sendMessage"
      ></update-dialog>

      <delete-dialog
        :isOpen="deleteDialog"
        :subdomain="subdomain"
        @close="closeDeleteModal"
        @sendMessage="sendMessage"
      ></delete-dialog>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import NewDialog from '../../components/dns/NewDialog'
import UpdateDialog from '../../components/dns/UpdateDialog'
import DeleteDialog from '../../components/dns/DeleteDialog'
import ListTable from '../../components/dns/ListTable'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    NewDialog,
    UpdateDialog,
    DeleteDialog,
    ListTable,
  },

  data() {
    return {
      greetingType: '',
      message: '',
      finishInitialize: false,
      canStore: false,
      canUpdate: false,
      canDelete: false,
      dns: {},
      domains: {},
      domain: {},
      subdomain: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
      headers: [
        {
          text: 'Name',
          value: 'full_domain',
        },
        {
          text: 'Type',
          value: 'dns_record_name',
        },
        {
          text: 'Value',
          value: 'value',
        },
        {
          text: 'TTL',
          value: 'ttl',
        },
        {
          text: 'Priority',
          value: 'priority',
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
    async openNewModal(domain) {
      this.newDialog = true
      this.domain = domain
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
      this.resetUpdateError()
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

      this.initDns()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
      }
    },

    async changeDomainId(domainId) {
      this.domain.id = domainId
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

    async initRoleOperation() {
      let canStoreResult = await axios.get('/api/roles/user/?has=api.dns.store')
      this.canStore = canStoreResult.data
    },

    async edit(subdomain) {
      this.subdomain = subdomain

      this.openEditModal()
    },

    async deleteSubDomain(subdomain) {
      this.subdomain = subdomain

      this.openDeleteModal()
    },
  },

  async created() {
    this.finishInitialize = false

    await this.initDns()
    await this.initRoleOperation()

    this.finishInitialize = true
  },
}
</script>
