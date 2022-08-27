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
        :message="greeting"
      ></greeting-message>

      <v-progress-linear
        v-show="pageLoading"
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

      <list-table :registrars="registrars"></list-table>

      <new-dialog :isOpen="newDialog" @close="closeNewModal"></new-dialog>

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
import { mapGetters, mapActions } from 'vuex'

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
      registrar: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
    }
  },

  computed: {
    ...mapGetters('registrar', [
      'registrars',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
  },

  methods: {
    ...mapActions('registrar', ['fetchRegistrars', 'initRole']),

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

  async created() {
    this.fetchRegistrars()
    this.initRole()
  },
}
</script>
