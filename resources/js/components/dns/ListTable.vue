<template>
  <v-data-table :headers="headers" :items="subdomains" :loading="loading">
    <template v-slot:[`item.action`]="{ item }">
      <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
        >edit</v-btn
      >
      <v-btn v-if="canDelete" x-small @click="deleteSubDomain(item)"
        >delete</v-btn
      >
    </template>
  </v-data-table>
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
    subdomains: {
      default() {
        return []
      },
      type: Array,
    },
  },

  data() {
    return {
      loading: true,
      canUpdate: false,
      canDelete: false,
    }
  },

  methods: {
    async roleCheck() {
      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.dns.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDeleteResult = await axios.get(
        '/api/roles/user/?has=api.dns.delete'
      )
      this.canDelete = canDeleteResult.data
    },

    edit(subdomain) {
      this.$emit('edit', subdomain)
    },

    deleteSubDomain(subdomain) {
      this.$emit('delete', subdomain)
    },
  },

  async created() {
    this.loading = true

    await this.roleCheck()

    this.loading = false
  },
}
</script>
