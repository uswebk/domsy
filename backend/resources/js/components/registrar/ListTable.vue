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
    <v-data-table :headers="headers" :items="registrars" :search="search">
      <template v-slot:[`item.link`]="{ item }">
        <a :href="item.link" target="_blank">{{ item.link }}</a>
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
      :registrar="registrar"
      @close="closeEditDialog"
    ></update-dialog>
    <delete-dialog
      :isOpen="isOpenDeleteDialog"
      :registrar="registrar"
      @close="closeDeleteDialog"
    ></delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import UpdateDialog from '../../components/registrar/UpdateDialog'
import DeleteDialog from '../../components/registrar/DeleteDialog'

export default {
  name: 'RegistrarListTable',
  components: {
    UpdateDialog,
    DeleteDialog,
  },
  props: {
    registrars: {
      default() {
        return []
      },
      type: Array,
    },
  },
  data() {
    return {
      loading: true,
      isOpenEditDialog: false,
      isOpenDeleteDialog: false,
      search: '',
      registrar: {},
      headers: [
        {
          text: 'Name',
          value: 'name',
        },
        {
          text: 'Link',
          value: 'link',
        },
        {
          text: 'Note',
          value: 'note',
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
    ...mapGetters('registrar', ['canUpdate', 'canDelete']),
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

    edit(registrar) {
      this.registrar = Object.assign({}, registrar)
      this.openEditDialog()
    },

    deletion(registrar) {
      this.registrar = Object.assign({}, registrar)
      this.openDeleteDialog()
    },
  },
}
</script>
