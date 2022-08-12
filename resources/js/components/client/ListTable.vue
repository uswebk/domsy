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
      :items="clients"
      :search="search"
      :loading="loading"
    >
      <template v-slot:[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deleteDomain(item)"
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
    headers: {
      default: null,
      type: Array,
      required: true,
    },
    clients: {
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
    }
  },

  methods: {
    async roleCheck() {
      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.clients.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDeleteResult = await axios.get(
        '/api/roles/user/?has=api.clients.delete'
      )
      this.canDelete = canDeleteResult.data
    },

    edit(client) {
      this.$emit('edit', client)
    },

    deleteRegistrar(client) {
      this.$emit('delete', client)
    },
  },

  async created() {
    this.loading = true

    await this.roleCheck()

    this.loading = false
  },
}
</script>
