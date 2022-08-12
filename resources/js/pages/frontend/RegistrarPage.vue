<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-domain'"
        :headlineText="'Registrar'"
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
        :registrars="registrars"
        @edit="edit"
        @delete="deleteRegistrar"
      ></list-table>

      <new-dialog
        :isOpen="newDialog"
        @close="closeNewModal"
        @sendMessage="sendMessage"
      ></new-dialog>

      <update-dialog
        :isOpen="editDialog"
        :registrar="registrar"
        @close="closeEditModal"
        @sendMessage="sendMessage"
      ></update-dialog>

      <delete-dialog
        :isOpen="deleteDialog"
        :registrar="registrar"
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
import ListTable from '../../components/registrar/ListTable'
import NewDialog from '../../components/registrar/NewDialog'
import UpdateDialog from '../../components/registrar/UpdateDialog'
import DeleteDialog from '../../components/registrar/DeleteDialog'

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
      registrars: [],
      registrar: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,

      headers: [
        {
          text: 'Name',
          value: 'name',
        },
        {
          text: 'Link',
          value: 'link',
        },
        {
          text: 'Note',
          value: 'note',
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
      this.message = ''
      this.greetingType = ''
    },

    sendMessage(result) {
      this.resetGreeting()

      this.initRegistrars()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
      }
    },

    async initRegistrars() {
      this.finishInitialize = false

      const result = await axios.get('/api/registrars')

      this.registrars = result.data

      this.finishInitialize = true
    },

    async initRoleOperation() {
      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.registrar.store'
      )
      this.canStore = canStoreResult.data

      this.finishInitialize = true
    },

    edit(registrar) {
      this.registrar = registrar

      this.openEditModal()
    },

    async deleteRegistrar(registrar) {
      this.resetGreeting()

      this.registrar = registrar

      this.openDeleteModal()
    },
  },

  created() {
    this.initRegistrars()
    this.initRoleOperation()
  },
}
</script>
