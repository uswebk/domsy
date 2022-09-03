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
    <v-data-table :headers="headers" :items="roles" :search="search">
      <template #[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>
    <role-update-dialog
      :is-open="isOpenEditDialog"
      :role="role"
      @close="closeEditDialog"
    ></role-update-dialog>
    <role-delete-dialog
      :is-open="isOpenDeleteDialog"
      :role="role"
      @close="closeDeleteDialog"
    ></role-delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

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
      search: '',
      isOpenEditDialog: false,
      isOpenDeleteDialog: false,
      role: {
        name: '',
        roles: {},
      },
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
  computed: {
    ...mapGetters('role', ['canUpdate', 'canDelete']),
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
    edit(role) {
      this.role.id = role.id
      this.role.name = role.name
      for (const key in role.role_items) {
        this.role.roles[role.role_items[key].menu_item_id] = true
      }
      this.openEditDialog()
    },
    deletion(role) {
      this.role = role
      this.role.roles = {}
      this.openDeleteDialog()
    },
  },
}
</script>
