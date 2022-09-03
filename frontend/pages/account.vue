<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-account-multiple'"
            :headline-text="'Account'"
          ></common-icon-head-line>
          <div class="py-5"></div>
          <common-greeting-message
            :type="greetingType"
            :message="greeting"
          ></common-greeting-message>
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
              <account-list-table :accounts="accounts"></account-list-table>
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
          <account-new-dialog
            :is-open="isOpenNewDialog"
            @close="closeNewDialog"
          ></account-new-dialog>
          <role-new-dialog
            :is-open="isOpenNewRoleDialog"
            @close="closeNewRoleDialog"
          ></role-new-dialog>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'AccountPage',
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
  created() {
    this.initRole()
    this.initRoleRole()
    this.fetchRoles()
    this.fetchRoleItems()
    this.fetchAccounts()
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
}
</script>
