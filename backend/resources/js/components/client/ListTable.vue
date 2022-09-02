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
    <v-data-table :headers="headers" :items="clients" :search="search">
      <template v-slot:[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>
    <update-dialog
      :isOpen="isOpenEditDialog"
      :client="client"
      @close="closeEditDialog"
    ></update-dialog>
    <delete-dialog
      :isOpen="isOpenDeleteDialog"
      :client="client"
      @close="closeDeleteDialog"
    ></delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import UpdateDialog from '../../components/client/UpdateDialog'
import DeleteDialog from '../../components/client/DeleteDialog'

export default {
  name: 'ClientListTable',
  components: {
    UpdateDialog,
    DeleteDialog,
  },

  props: {
    clients: {
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
      client: {},
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
          text: 'Zip',
          value: 'zip',
        },
        {
          text: 'Address',
          value: 'address',
        },
        {
          text: 'TEL',
          value: 'phone_number',
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
    ...mapGetters('client', ['canUpdate', 'canDelete']),
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

    edit(client) {
      this.client = Object.assign({}, client)
      this.openEditDialog()
    },

    deletion(client) {
      this.client = Object.assign({}, client)
      this.openDeleteDialog()
    },
  },
}
</script>
