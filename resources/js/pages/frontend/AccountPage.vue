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
        :message="greeting"
      ></greeting-message>

      <v-progress-linear
        v-show="pageLoading"
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
            @click="openNewDialog"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>

          <list-table :accounts="accounts"></list-table>
        </v-tab-item>
        <v-tab-item value="role">
          <!-- <v-btn
            v-if="canRoleStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewRoleModal"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn> -->

          <!-- <role-list-table
            :roles="roles"
            @edit="edit"
            @delete="deleteRole"
          ></role-list-table> -->
        </v-tab-item>
      </v-tabs-items>

      <new-dialog
        :isOpen="isOpenNewDialog"
        @close="closeNewDialog"
      ></new-dialog>

      <!--

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
      ></role-delete-dialog> -->
    </v-container>
  </v-main>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import ListTable from '../../components/account/ListTable'
import RoleListTable from '../../components/role/ListTable'
import NewDialog from '../../components/account/NewDialog'
import RoleNewDialog from '../../components/role/NewDialog'
import RoleUpdateDialog from '../../components/role/UpdateDialog'
import RoleDeleteDialog from '../../components/role/DeleteDialog'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    RoleListTable,
    NewDialog,
    RoleNewDialog,
    RoleUpdateDialog,
    RoleDeleteDialog,
  },

  computed: {
    ...mapGetters('account', [
      'canStore',
      'canRoleStore',
      'pageLoading',
      'greeting',
      'greetingType',
      'accounts',
      'roles',
    ]),
  },

  data() {
    return {
      tab: '',
      isOpenNewDialog: false,
      newRoleDialog: false,
      // editRoleDialog: false,
      // deleteRoleDialog: false,
    }
  },

  methods: {
    ...mapActions('account', ['initRole', 'fetchRoles', 'fetchAccounts']),

    openNewDialog() {
      this.isOpenNewDialog = true
    },

    // openNewRoleModal() {
    //   this.newRoleDialog = true
    // },

    // openEditRoleModal() {
    //   this.editRoleDialog = true
    // },

    // openDeleteRoleModal() {
    //   this.deleteRoleDialog = true
    // },

    closeNewDialog() {
      this.isOpenNewDialog = false
    },

    // closeNewRoleModal() {
    //   this.newRoleDialog = false
    // },

    // closeEditRoleModal() {
    //   this.editRoleDialog = false
    // },

    // closeDeleteRoleModal() {
    //   this.deleteRoleDialog = false
    // },

    // editRole(role) {
    //   this.role = {}
    //   this.role.roleItems = {}

    //   this.role.id = role.id
    //   this.role.name = role.name
    //   for (let key in role.role_items) {
    //     this.role.roleItems[role.role_items[key].menu_item_id] = true
    //   }

    //   this.openEditRoleModal()
    // },

    // async deleteRole(role) {
    //   this.resetGreeting()

    //   this.role.id = role.id
    //   this.role.name = role.name

    //   this.openDeleteRoleModal()
    // },
  },
  created() {
    this.initRole()
    this.fetchRoles()
    this.fetchAccounts()
  },
}
</script>

<style>
.modal-backdrop {
  opacity: 0.5;
}
</style>
