<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-account-group'"
        :headlineText="'Client'"
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

      <list-table
        :headers="headers"
        :clients="clients"
        @edit="edit"
        @delete="deleteClient"
      ></list-table>

      <new-dialog
        :isOpen="newDialog"
        @close="closeNewModal"
        @sendMessage="sendMessage"
      ></new-dialog>

      <update-dialog
        :isOpen="editDialog"
        :client="client"
        @close="closeEditModal"
        @sendMessage="sendMessage"
      ></update-dialog>

      <delete-dialog
        :isOpen="deleteDialog"
        :client="client"
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
import ListTable from '../../components/client/ListTable'
import NewDialog from '../../components/client/NewDialog'
import UpdateDialog from '../../components/client/UpdateDialog'
import DeleteDialog from '../../components/client/DeleteDialog'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
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
      clients: [],
      client: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,

      headers: [
        {
          text: 'Name',
          value: 'name',
        },
        {
          text: 'Email',
          value: 'email',
        },
        {
          text: 'Zip',
          value: 'zip',
        },
        {
          text: 'Address',
          value: 'address',
        },
        {
          text: 'TEL',
          value: 'phone_number',
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

      this.initClients()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
      }
    },

    async initClients() {
      this.finishInitialize = false

      const result = await axios.get('/api/clients')

      this.clients = result.data

      this.finishInitialize = true
    },

    async initRoleOperation() {
      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.clients.store'
      )
      this.canStore = canStoreResult.data

      this.finishInitialize = true
    },

    edit(client) {
      this.client = client

      this.openEditModal()
    },

    async deleteClient(client) {
      this.resetGreeting()

      this.client = client

      this.openDeleteModal()
    },
  },

  created() {
    this.initClients()
    this.initRoleOperation()
  },
}
</script>
