<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-account-multiple'"
        :headlineText="'Account'"
      ></icon-head-line>

      <div class="py-5"></div>

      <greeting-message
        :type="greetingType"
        :message="message"
      ></greeting-message>

      <v-progress-linear
        v-show="!finishInitialize"
        color="yellow darken-2"
        indeterminate
        rounded
        height="6"
      ></v-progress-linear>

      <v-tabs v-model="tab">
        <v-tab href="#account">Account</v-tab>
        <v-tab href="#role">Role</v-tab>
      </v-tabs>

      <v-container class="py-1"></v-container>
      <v-tabs-items v-model="tab">
        <v-tab-item value="account">
          <v-btn
            v-if="canStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewModal"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>

          <list-table
            :accounts="users"
            @edit="edit"
            @delete="deleteUser"
          ></list-table>
        </v-tab-item>
        <v-tab-item value="role">
          <v-btn
            v-if="canRoleStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewRoleModal"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>

          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">Name</th>
                  <th class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="role in roles" :key="role.id">
                  <td>{{ role.name }}</td>
                  <td>
                    <span v-if="role.id !== 1">
                      <v-btn
                        v-if="canRoleUpdate"
                        x-small
                        color="primary"
                        @click="editRole(role)"
                        >edit</v-btn
                      >
                      <v-btn
                        v-if="canRoleDelete"
                        x-small
                        @click="deleteRole(role)"
                        >delete</v-btn
                      >
                    </span>
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-tab-item>
      </v-tabs-items>

      <new-dialog
        :isOpen="newDialog"
        @close="closeNewModal"
        @sendMessage="sendMessage"
      ></new-dialog>

      <update-dialog
        :isOpen="editDialog"
        :account="user"
        @close="closeEditModal"
        @sendMessage="sendMessage"
      ></update-dialog>

      <delete-dialog
        :isOpen="deleteDialog"
        :account="user"
        @close="closeDeleteModal"
        @sendMessage="sendMessage"
      ></delete-dialog>

      <!-- Role New Dialog -->
      <v-dialog v-model="newRoleDialog" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="text-h6">Role Create</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      class="mt-5"
                      label="Role Name"
                      v-model="newRoleName"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="storeErrors.name" />
                  </v-col>
                  <div class="my-10"></div>
                  <v-col
                    cols="6"
                    v-for="menuItem in menuItems"
                    :key="menuItem.id"
                  >
                    <v-switch
                      v-model="newRoles[menuItem.id]"
                      :label="menuItem.description"
                    >
                    </v-switch>
                  </v-col>
                </v-row>

                <div class="my-5"></div>

                <v-btn color="primary" @click="storeRole">Create</v-btn>
              </v-form>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeNewRoleModal">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Role Update Dialog -->
      <v-dialog v-model="editRoleDialog" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="text-h6">Role Update</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      class="mt-5"
                      label="Role Name"
                      v-model="role.name"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessage :message="updateErrors.name" />
                  </v-col>
                  <div class="my-10"></div>
                  <v-col
                    cols="6"
                    v-for="menuItem in menuItems"
                    :key="menuItem.id"
                  >
                    <v-switch
                      v-model="role.roleItems[menuItem.id]"
                      :label="menuItem.description"
                    >
                    </v-switch>
                  </v-col>
                </v-row>

                <div class="my-5"></div>

                <v-btn color="primary" @click="updateRole">Update</v-btn>
              </v-form>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeEditRoleModal">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Delete Dialog -->
      <v-dialog v-model="deleteRoleDialog" max-width="290">
        <v-card>
          <v-card-title class="text-h5"> Deletion confirmation </v-card-title>

          <v-card-text>
            Do you want to delete the 「{{ role.name }}」 ?
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="gray darken-1" text @click="closeDeleteRoleModal">
              Close
            </v-btn>

            <v-btn color="red darken-1" text @click="deleteRoleExecute">
              Delete
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import ListTable from '../../components/account/ListTable'
import NewDialog from '../../components/account/NewDialog'
import UpdateDialog from '../../components/account/UpdateDialog'
import DeleteDialog from '../../components/account/DeleteDialog'

import ValidationErrorMessage from '../../components/form/ValidationErrorMessage'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    NewDialog,
    UpdateDialog,
    DeleteDialog,
    ValidationErrorMessage,
  },

  data() {
    return {
      greetingType: '',
      message: '',
      tab: '',
      canStore: false,
      canRoleStore: false,
      canRoleUpdate: false,
      canRoleDelete: false,
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
      newRoleDialog: false,
      editRoleDialog: false,
      deleteRoleDialog: false,
      finishInitialize: false,
      users: [],
      user: {},
      roles: {},
      role: {
        roleItems: {},
      },
      storeErrors: {},
      updateErrors: {},
      menuItems: {},
      newRoles: {},
      newRoleName: '',
    }
  },

  methods: {
    openNewModal() {
      this.newDialog = true
    },

    openNewRoleModal() {
      this.newRoleDialog = true
    },

    openEditModal() {
      this.editDialog = true
    },

    openEditRoleModal() {
      this.editRoleDialog = true
    },

    openDeleteRoleModal() {
      this.deleteRoleDialog = true
    },

    openDeleteModal() {
      this.deleteDialog = true
    },

    closeNewModal() {
      this.newDialog = false
    },

    closeNewRoleModal() {
      this.newRoleDialog = false
    },

    closeEditModal() {
      this.editDialog = false
    },

    closeEditRoleModal() {
      this.editRoleDialog = false
    },

    closeDeleteModal() {
      this.deleteDialog = false
    },

    closeDeleteRoleModal() {
      this.deleteRoleDialog = false
    },

    resetNewRoles() {
      this.newRoles = {}
      this.newRoleName = ''
    },

    resetGreeting() {
      this.greetingType = ''
      this.message = ''
    },

    sendMessage(result) {
      this.resetGreeting()

      this.initUsers()
      this.initRoles()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
      }
    },

    async storeRole() {
      this.resetGreeting()

      try {
        const result = await axios.post('/api/roles', {
          name: this.newRoleName,
          roles: this.newRoles,
        })

        if (result.status === 200) {
          this.greeting = 'Create success'
        }

        this.initRoles()
        this.closeNewRoleModal()
        this.resetNewRoles()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeNewRoleModal()
          this.resetNewRoles()
        }

        if (status === 422) {
          var responseErrors = error.response.data.errors
          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.storeErrors = errors
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeNewRoleModal()
          this.resetNewRoles()
        }
      }
    },

    async updateRole() {
      this.resetGreeting()

      try {
        const result = await axios.put('/api/roles/' + this.role.id, {
          name: this.role.name,
          roles: this.role.roleItems,
        })

        if (result.status === 200) {
          this.greeting = 'Update success'
        }

        this.initRoles()
        this.closeEditRoleModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeEditRoleModal()
        }

        if (status === 422) {
          var responseErrors = error.response.data.errors
          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.storeErrors = errors
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeEditRoleModal()
        }
      }
    },

    async deleteRoleExecute() {
      try {
        const result = await axios.delete('/api/roles/' + this.role.id)

        if (result.status === 200) {
          this.greeting = 'Delete success'
        }

        this.initRoles()
        this.closeDeleteRoleModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeDeleteRoleModal()
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeDeleteRoleModal()
        }
      }
    },

    edit(user) {
      this.user.id = user.id
      this.user.name = user.name
      this.user.email = user.email
      this.user.roleId = user.role_id

      this.openEditModal()
    },

    editRole(role) {
      this.role = {}
      this.role.roleItems = {}

      this.role.id = role.id
      this.role.name = role.name
      for (let key in role.role_items) {
        this.role.roleItems[role.role_items[key].menu_item_id] = true
      }

      this.openEditRoleModal()
    },

    async deleteUser(user) {
      this.user = user

      this.openDeleteModal()
    },

    async deleteRole(role) {
      this.resetGreeting()

      this.role.id = role.id
      this.role.name = role.name

      this.openDeleteRoleModal()
    },

    async initUsers() {
      const result = await axios.get('api/users')

      this.users = result.data
    },

    async initRoles() {
      const result = await axios.get('api/roles')

      this.roles = result.data
    },

    async initMenuItems() {
      const result = await axios.get('api/menus/items')

      this.menuItems = result.data
    },

    async initRoleOperation() {
      this.finishInitialize = false

      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.accounts.store'
      )
      this.canStore = canStoreResult.data

      let canRoleStoreResult = await axios.get(
        '/api/roles/user/?has=api.roles.store'
      )
      this.canRoleStore = canRoleStoreResult.data

      let canRoleUpdateResult = await axios.get(
        '/api/roles/user/?has=api.roles.update'
      )
      this.canRoleUpdate = canRoleUpdateResult.data

      let canRoleDeleteResult = await axios.get(
        '/api/roles/user/?has=api.roles.delete'
      )
      this.canRoleDelete = canRoleDeleteResult.data

      this.finishInitialize = true
    },

    async initialize() {
      this.initUsers()
      this.initRoles()
      this.initMenuItems()
      this.initRoleOperation()
    },
  },
  created() {
    this.initialize()
  },
}
</script>

<style>
.modal-backdrop {
  opacity: 0.5;
}
</style>
