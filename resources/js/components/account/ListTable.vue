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
    <v-data-table
      :headers="headers"
      :items="accounts"
      :search="search"
      :loading="loading"
    >
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
        <v-btn v-if="canDelete" x-small @click="deleteExecute(item)"
          >delete</v-btn
        >
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'ListTable',
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
      loading: true,
      search: '',
      canUpdate: false,
      canDelete: false,
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
    async roleCheck() {
      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.accounts.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDeleteResult = await axios.get(
        '/api/roles/user/?has=api.accounts.delete'
      )
      this.canDelete = canDeleteResult.data
    },

    edit(account) {
      this.$emit('edit', account)
    },

    deleteExecute(account) {
      this.$emit('delete', account)
    },
  },

  async created() {
    this.loading = true

    await this.roleCheck()

    this.loading = false
  },
}
</script>
