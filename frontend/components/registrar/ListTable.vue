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
      <template #[`item.link`]="{ item }">
        <a :href="item.link" target="_blank">{{ item.link }}</a>
      </template>
      <template #[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>
    <registrar-update-dialog
      :is-open="isOpenEditDialog"
      :registrar="registrar"
      @close="closeEditDialog"
    ></registrar-update-dialog>
    <registrar-delete-dialog
      :is-open="isOpenDeleteDialog"
      :registrar="registrar"
      @close="closeDeleteDialog"
    ></registrar-delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'RegistrarListTable',
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
