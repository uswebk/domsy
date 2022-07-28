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

      <v-btn class="ma-2" color="primary" small @click="openNewModal">
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
                <v-btn x-small color="primary" @click="edit(user)">edit</v-btn>
                <v-btn x-small @click="deleteUser(user)">delete</v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>

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
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
      storeErrors: {},
      updateErrors: {},
      errors: {},
      users: {},
      user: {},
      roles: {},
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

    openEditModal() {
      this.editDialog = true
    },

    openDeleteModal() {
      this.deleteDialog = true
    },

    closeNewModal() {
      this.resetStoreError()
      this.newDialog = false
    },

    closeEditModal() {
      this.resetUpdateError()
      this.editDialog = false
    },

    closeDeleteModal() {
      this.deleteDialog = false
    },

    resetNewUser() {
      this.name = ''
      this.email = ''
      this.roleId = ''
      this.password = ''
      this.passwordConfirmation = ''
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

    edit(user) {
      this.user.id = user.id
      this.user.name = user.name
      this.user.email = user.email
      this.user.roleId = user.role_id

      this.openEditModal()
    },

    async deleteUser(user) {
      this.resetGreeting()

      this.user = user

      this.openDeleteModal()
    },

    async initUsers() {
      const result = await axios.get('api/users')
      this.users = result.data
    },

    async initRoles() {
      const result = await axios.get('api/roles')

      this.roles = result.data
    },

    async initialize() {
      this.initUsers()
      this.initRoles()
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
