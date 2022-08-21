<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-account-multiple'"
        :headlineText="'Account'"
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

      <v-tabs v-model="tab">
        <v-tab href="#account">Account</v-tab>
        <v-tab href="#role">Role</v-tab>
      </v-tabs>

      <v-container class="py-1"></v-container>
      <v-tabs-items v-model="tab">
        <v-tab-item value="account">
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
            :accounts="users"
            @edit="edit"
            @delete="deleteUser"
          ></list-table>
        </v-tab-item>
        <v-tab-item value="role">
          <v-btn
            v-if="canRoleStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewRoleModal"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>

          <role-list-table
            :roles="roles"
            @edit="edit"
            @delete="deleteRole"
          ></role-list-table>
        </v-tab-item>
      </v-tabs-items>

      <new-dialog
        :isOpen="newDialog"
        @close="closeNewModal"
        @sendMessage="sendMessage"
      ></new-dialog>

      <update-dialog
        :isOpen="editDialog"
        :account="user"
        @close="closeEditModal"
        @sendMessage="sendMessage"
      ></update-dialog>

      <delete-dialog
        :isOpen="deleteDialog"
        :account="user"
        @close="closeDeleteModal"
        @sendMessage="sendMessage"
      ></delete-dialog>

      <role-new-dialog
        :isOpen="newRoleDialog"
        @close="closeNewRoleModal"
        @sendMessage="sendMessage"
      ></role-new-dialog>

      <role-update-dialog
        :isOpen="editRoleDialog"
        :role="role"
        @close="closeEditRoleModal"
        @sendMessage="sendMessage"
      ></role-update-dialog>

      <role-delete-dialog
        :isOpen="deleteRoleDialog"
        :role="role"
        @close="closeDeleteRoleModal"
        @sendMessage="sendMessage"
      ></role-delete-dialog>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import ListTable from '../../components/account/ListTable'
import RoleListTable from '../../components/role/ListTable'
import NewDialog from '../../components/account/NewDialog'
import RoleNewDialog from '../../components/role/NewDialog'
import UpdateDialog from '../../components/account/UpdateDialog'
import RoleUpdateDialog from '../../components/role/UpdateDialog'
import DeleteDialog from '../../components/account/DeleteDialog'
import RoleDeleteDialog from '../../components/role/DeleteDialog'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    RoleListTable,
    NewDialog,
    RoleNewDialog,
    UpdateDialog,
    RoleUpdateDialog,
    DeleteDialog,
    RoleDeleteDialog,
  },

  data() {
    return {
      greetingType: '',
      message: '',
      tab: '',
      canStore: false,
      canRoleStore: false,
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
      newRoleDialog: false,
      editRoleDialog: false,
      deleteRoleDialog: false,
      finishInitialize: false,
      users: [],
      user: {},
      roles: [],
      role: {
        roleItems: [],
      },
    }
  },

  methods: {
    openNewModal() {
      this.newDialog = true
    },

    openNewRoleModal() {
      this.newRoleDialog = true
    },

    openEditModal() {
      this.editDialog = true
    },

    openEditRoleModal() {
      this.editRoleDialog = true
    },

    openDeleteRoleModal() {
      this.deleteRoleDialog = true
    },

    openDeleteModal() {
      this.deleteDialog = true
    },

    closeNewModal() {
      this.newDialog = false
    },

    closeNewRoleModal() {
      this.newRoleDialog = false
    },

    closeEditModal() {
      this.editDialog = false
    },

    closeEditRoleModal() {
      this.editRoleDialog = false
    },

    closeDeleteModal() {
      this.deleteDialog = false
    },

    closeDeleteRoleModal() {
      this.deleteRoleDialog = false
    },

    resetGreeting() {
      this.greetingType = ''
      this.message = ''
    },

    sendMessage(result) {
      this.resetGreeting()

      this.initUsers()
      this.initRoles()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
      }
    },

    edit(user) {
      this.user.id = user.id
      this.user.name = user.name
      this.user.email = user.email
      this.user.roleId = user.role_id

      this.openEditModal()
    },

    editRole(role) {
      this.role = {}
      this.role.roleItems = {}

      this.role.id = role.id
      this.role.name = role.name
      for (let key in role.role_items) {
        this.role.roleItems[role.role_items[key].menu_item_id] = true
      }

      this.openEditRoleModal()
    },

    async deleteUser(user) {
      this.user = user

      this.openDeleteModal()
    },

    async deleteRole(role) {
      this.resetGreeting()

      this.role.id = role.id
      this.role.name = role.name

      this.openDeleteRoleModal()
    },

    async initUsers() {
      const result = await axios.get('api/users')

      this.users = result.data
    },

    async initRoles() {
      const result = await axios.get('api/roles')

      this.roles = result.data
    },

    async initRoleOperation() {
      this.finishInitialize = false

      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.accounts.store'
      )
      this.canStore = canStoreResult.data

      let canRoleStoreResult = await axios.get(
        '/api/roles/user/?has=api.roles.store'
      )
      this.canRoleStore = canRoleStoreResult.data

      this.finishInitialize = true
    },

    async initialize() {
      this.initUsers()
      this.initRoles()
      this.initRoleOperation()
    },
  },
  created() {
    this.initialize()
  },
}
</script>

<style>
.modal-backdrop {
  opacity: 0.5;
}
</style>
