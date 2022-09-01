<template>
  <div>
    <v-data-table :headers="headers" :items="subdomains" dense>
      <template v-slot:[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>
    <update-dialog
      :isOpen="isOpenEditDialog"
      :subdomain="subdomain"
      @close="closeEditDialog"
    ></update-dialog>
    <delete-dialog
      :isOpen="isOpenDeleteDialog"
      :subdomain="subdomain"
      @close="closeDeleteDialog"
    ></delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import UpdateDialog from '../../components/dns/UpdateDialog'
import DeleteDialog from '../../components/dns/DeleteDialog'

export default {
  name: 'DnsListTable',
  components: {
    UpdateDialog,
    DeleteDialog,
  },
  props: {
    subdomains: {
      default() {
        return []
      },
      type: Array,
    },
  },
  computed: {
    ...mapGetters('dns', ['canUpdate', 'canDelete']),
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
