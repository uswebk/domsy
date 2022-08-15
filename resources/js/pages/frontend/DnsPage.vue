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

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    NewDialog,
    UpdateDialog,
    DeleteDialog,
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
      this.subdomain = subdomain

      this.openEditModal()
    },

    async deleteSubDomain(subdomain) {
      this.subdomain = subdomain

      this.openDeleteModal()
    },
  },

  created() {
    this.initDns()
    this.initRoleOperation()
  },
}
</script>
