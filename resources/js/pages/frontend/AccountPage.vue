<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-account-multiple</v-icon> Account
      </h1>

      <div class="py-5"></div>

      <v-alert dense text dismissible type="success" v-if="greeting">{{
        greeting
      }}</v-alert>
      <v-alert dense text dismissible type="error" v-if="alert">{{
        alert
      }}</v-alert>

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

          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">Name</th>
                  <th class="text-left">Email</th>
                  <th class="text-left">Role</th>
                  <th class="text-center">Verified</th>
                  <th class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.role.name }}</td>
                  <td class="text-center">
                    <span v-if="user.email_verified_at"
                      ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
                    >
                  </td>
                  <td>
                    <v-btn
                      v-if="canUpdate"
                      x-small
                      color="primary"
                      @click="edit(user)"
                      >edit</v-btn
                    >
                    <v-btn v-if="canDelete" x-small @click="deleteUser(user)"
                      >delete</v-btn
                    >
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
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

      <!-- New Dialog -->
      <v-dialog v-model="newDialog" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="text-h6">Account Create</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      class="mt-5"
                      label="Name"
                      v-model="name"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.name"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Email"
                      v-model="email"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.email"
                    />

                    <v-select
                      class="mt-5"
                      v-model="roleId"
                      :items="roles"
                      item-text="name"
                      item-value="id"
                      label="Role"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.role_id"
                    />

                    <v-text-field
                      class="mt-5"
                      v-model="password"
                      type="password"
                      name="password"
                      label="Password"
                      hint="At least 8 characters"
                      counter
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="errors.password"
                    />
                    <v-text-field
                      class="mt-5"
                      v-model="passwordConfirmation"
                      type="password"
                      name="password_confirmation"
                      label="Confirm Password"
                      counter
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="errors.password_confirmation"
                    />
                  </v-col>
                </v-row>

                <div class="my-5"></div>

                <v-btn color="primary" @click="store">Create</v-btn>
              </v-form>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeNewModal">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Update Dialog -->
      <v-dialog v-model="editDialog" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="text-h6">Account Edit</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      class="mt-5"
                      label="Name"
                      v-model="user.name"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.name"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Email"
                      v-model="user.email"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.email"
                    />

                    <v-select
                      class="mt-5"
                      v-model="user.roleId"
                      :items="roles"
                      item-text="name"
                      item-value="id"
                      label="Role"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.role_id"
                    />
                  </v-col>
                </v-row>
                <div class="my-5"></div>
                <v-btn color="primary" @click="update">Update</v-btn>
              </v-form>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeEditModal">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Delete Dialog -->
      <v-dialog v-model="deleteDialog" max-width="290">
        <v-card>
          <v-card-title class="text-h5"> Deletion confirmation </v-card-title>

          <v-card-text>
            Do you want to delete the 「{{ user.name }}」 ?
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="gray darken-1" text @click="closeDeleteModal">
              Close
            </v-btn>

            <v-btn color="red darken-1" text @click="deleteExecute">
              Delete
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

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
                    <ValidationErrorMessageComponent
                      :message="storeErrors.name"
                    />
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
                    <ValidationErrorMessageComponent
                      :message="updateErrors.name"
                    />
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
import ValidationErrorMessageComponent from '../../components/form/ValidationErrorMessageComponent'

export default {
  components: {
    ValidationErrorMessageComponent,
  },

  data() {
    return {
      greeting: '',
      alert: '',
      tab: '',
      canStore: false,
      canUpdate: false,
      canDelete: false,
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
      storeErrors: {},
      updateErrors: {},
      errors: {},
      users: {},
      user: {},
      roles: {},
      role: {
        roleItems: {},
      },
      menuItems: {},
      newRoles: {},
      newRoleName: '',
      name: '',
      email: '',
      roleId: null,
      password: '',
      passwordConfirmation: '',
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
      this.resetStoreError()
      this.newDialog = false
    },

    closeNewRoleModal() {
      this.newRoleDialog = false
    },

    closeEditModal() {
      this.resetUpdateError()
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

    resetNewUser() {
      this.name = ''
      this.email = ''
      this.roleId = ''
      this.password = ''
      this.passwordConfirmation = ''
    },

    resetNewRoles() {
      this.newRoles = {}
      this.newRoleName = ''
    },

    resetGreeting() {
      this.greeting = ''
      this.alert = ''
    },

    resetStoreError() {
      this.storeErrors = {}
    },

    resetUpdateError() {
      this.updateErrors = {}
    },

    async store() {
      this.resetGreeting()

      try {
        const result = await axios.post('/api/accounts', {
          name: this.name,
          role_id: this.roleId,
          email: this.email,
          password: this.password,
          password_confirmation: this.passwordConfirmation,
        })

        if (result.status === 200) {
          this.greeting = 'Create success and sent you an approval email.'
        }

        this.initUsers()
        this.closeNewModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeNewModal()
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
          this.closeNewModal()
        }
      }

      this.resetNewUser()
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

    async update() {
      this.resetGreeting()

      try {
        const result = await axios.put('/api/accounts/' + this.user.id, {
          name: this.user.name,
          role_id: this.user.roleId,
          email: this.user.email,
        })

        if (result.status === 200) {
          this.greeting = 'Update success'
        }
        this.initUsers()
        this.closeEditModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeEditModal()
        }

        if (status === 422) {
          var responseErrors = error.response.data.errors

          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.updateErrors = errors
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeEditModal()
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

    async deleteExecute() {
      try {
        const result = await axios.delete('/api/accounts/' + this.user.id)

        if (result.status === 200) {
          this.greeting = 'Delete success'
        }

        this.initUsers()
        this.closeDeleteModal()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeDeleteModal()
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeDeleteModal()
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
      this.resetGreeting()

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
      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.accounts.store'
      )
      this.canStore = canStoreResult.data

      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.accounts.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDeleteResult = await axios.get(
        '/api/roles/user/?has=api.accounts.delete'
      )
      this.canDelete = canDeleteResult.data

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
    },

    async initialize() {
      this.initUsers()
      this.initRoles()
      this.initMenuItems()
      await this.initRoleOperation()

      this.finishInitialize = true
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
