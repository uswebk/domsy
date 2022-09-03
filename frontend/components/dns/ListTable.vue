<template>
  <div>
    <v-data-table :headers="headers" :items="subdomains" dense>
      <template #[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>
    <dns-update-dialog
      :is-open="isOpenEditDialog"
      :subdomain="subdomain"
      @close="closeEditDialog"
    ></dns-update-dialog>
    <dns-delete-dialog
      :is-open="isOpenDeleteDialog"
      :subdomain="subdomain"
      @close="closeDeleteDialog"
    ></dns-delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'DnsListTable',
  props: {
    subdomains: {
      default() {
        return []
      },
      type: Array,
    },
  },
  data() {
    return {
      isOpenEditDialog: false,
      isOpenDeleteDialog: false,
      subdomain: {},
      headers: [
        {
          text: 'Name',
          value: 'full_domain',
        },
        {
          text: 'Type',
          value: 'dns_record_name',
        },
        {
          text: 'Value',
          value: 'value',
        },
        {
          text: 'TTL',
          value: 'ttl',
        },
        {
          text: 'Priority',
          value: 'priority',
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
    ...mapGetters('dns', ['canUpdate', 'canDelete']),
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
    edit(subdomain) {
      this.subdomain = Object.assign({}, subdomain)
      this.openEditDialog()
    },
    deletion(subdomain) {
      this.subdomain = Object.assign({}, subdomain)
      this.openDeleteDialog()
    },
  },
}
</script>
