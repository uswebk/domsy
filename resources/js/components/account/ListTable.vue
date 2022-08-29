<template>
  <div>
    <v-row justify="end">
      <v-col cols="4">
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <div class="my-2"></div>
    <v-data-table :headers="headers" :items="accounts" :search="search">
      <template v-slot:[`item.role_id`]="{ item }">
        {{ item.role.name }}
      </template>
      <template v-slot:[`item.email_verified_at`]="{ item }">
        <span v-if="item.email_verified_at"
          ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
        >
      </template>
      <template v-slot:[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>

    <update-dialog
      :isOpen="isOpenEditDialog"
      :account="account"
      @close="closeEditDialog"
    ></update-dialog>

    <delete-dialog
      :isOpen="isOpenDeleteDialog"
      :account="account"
      @close="closeDeleteDialog"
    ></delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import UpdateDialog from '../../components/account/UpdateDialog'
import DeleteDialog from '../../components/account/DeleteDialog'

export default {
  name: 'ListTable',

  components: {
    UpdateDialog,
    DeleteDialog,
  },

  props: {
    accounts: {
      default() {
        return []
      },
      type: Array,
    },
  },

  data() {
    return {
      search: '',
      isOpenEditDialog: false,
      isOpenDeleteDialog: false,
      account: {},
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
          text: 'Role',
          value: 'role_id',
        },
        {
          text: 'Verified',
          value: 'email_verified_at',
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
    ...mapGetters('account', ['canUpdate', 'canDelete']),

    openEditDialog() {
      this.isOpenEditDialog = true
    },

    closeEditDialog() {
      this.isOpenEditDialog = false
    },

    openDeleteDialog() {
      this.isOpenDeleteDialog = true
    },

    closeDeleteDialog() {
      this.isOpenDeleteDialog = false
    },

    edit(account) {
      this.account.id = account.id
      this.account.name = account.name
      this.account.email = account.email
      this.account.role_id = account.role_id

      this.openEditDialog()
    },

    deletion(account) {
      this.account = account
      this.openDeleteDialog()
    },
  },
}
</script>
