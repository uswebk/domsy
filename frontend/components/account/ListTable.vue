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
      <template #[`item.name`]="{ item }">
        {{ item.emoji }} - {{ item.name }}
      </template>
      <template #[`item.role_id`]="{ item }">
        {{ item.role.name }}
      </template>
      <template #[`item.last_login_at`]="{ item }"
        >{{ $dateTimeHyphen(item.last_login_at) }}
      </template>
      <template #[`item.email_verified_at`]="{ item }">
        <span v-if="item.email_verified_at">
          <v-icon small>mdi-checkbox-marked-circle</v-icon>
        </span>
      </template>
      <template #[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>
    <account-update-dialog
      :is-open="isOpenEditDialog"
      :account="account"
      @close="closeEditDialog"
    ></account-update-dialog>
    <account-delete-dialog
      :is-open="isOpenDeleteDialog"
      :account="account"
      @close="closeDeleteDialog"
    ></account-delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'AccountListTable',
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
          text: 'Last Login',
          value: 'last_login_at',
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
  computed: {
    ...mapGetters('account', ['canUpdate', 'canDelete']),
  },
  methods: {
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
      this.account = Object.assign({}, account)
      this.openEditDialog()
    },
    deletion(account) {
      this.account = Object.assign({}, account)
      this.openDeleteDialog()
    },
  },
}
</script>
