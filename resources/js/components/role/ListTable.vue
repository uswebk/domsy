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
      :items="roles"
      :search="search"
      :loading="loading"
    >
      <template v-slot:[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'RoleListTable',
  props: {
    roles: {
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
        '/api/roles/user/?has=api.roles.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDeleteResult = await axios.get(
        '/api/roles/user/?has=api.roles.delete'
      )
      this.canDelete = canDeleteResult.data
    },

    edit(role) {
      this.$emit('edit', role)
    },

    deletion(role) {
      this.$emit('delete', role)
    },
  },

  async created() {
    this.loading = true

    await this.roleCheck()

    this.loading = false
  },
}
</script>
