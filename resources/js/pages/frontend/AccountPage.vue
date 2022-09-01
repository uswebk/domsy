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
          <v-btn
            v-if="canRoleStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewRoleDialog"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>
          <role-list-table :roles="roles"></role-list-table>
        </v-tab-item>
      </v-tabs-items>
      <new-dialog
        :isOpen="isOpenNewDialog"
        @close="closeNewDialog"
      ></new-dialog>
      <role-new-dialog
        :isOpen="isOpenNewRoleDialog"
        @close="closeNewRoleDialog"
      ></role-new-dialog>
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

export default {
  name: 'AccountPage',
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    RoleListTable,
    NewDialog,
    RoleNewDialog,
  },
  data() {
    return {
      tab: '',
      isOpenNewDialog: false,
      isOpenNewRoleDialog: false,
    }
  },
  computed: {
    ...mapGetters('account', [
      'canStore',
      'greeting',
      'greetingType',
      'accounts',
    ]),
    ...mapGetters('account', {
      pageLoadingAccount: 'pageLoading',
    }),
    ...mapGetters('role', {
      roles: 'roles',
      canRoleStore: 'canStore',
      pageLoadingRole: 'pageLoading',
    }),
    pageLoading() {
      return this.pageLoadingAccount || this.pageLoadingRole
    },
  },
  methods: {
    ...mapActions('account', ['initRole', 'fetchAccounts']),
    ...mapActions('role', {
      fetchRoles: 'fetchRoles',
      fetchRoleItems: 'fetchRoleItems',
      initRoleRole: 'initRole',
    }),

    openNewDialog() {
      this.isOpenNewDialog = true
    },

    openNewRoleDialog() {
      this.isOpenNewRoleDialog = true
    },

    closeNewDialog() {
      this.isOpenNewDialog = false
    },

    closeNewRoleDialog() {
      this.isOpenNewRoleDialog = false
    },
  },
  created() {
    this.initRole()
    this.initRoleRole()
    this.fetchRoles()
    this.fetchRoleItems()
    this.fetchAccounts()
  },
}
</script>
