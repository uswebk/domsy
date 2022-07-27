<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-account-group</v-icon> Client
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
              <th class="text-left">Address</th>
              <th class="text-left">TEL</th>
              <th class="text-left">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in clients" :key="client.id">
              <td>{{ client.name }}</td>
              <td>{{ client.email }}</td>
              <td>{{ client.zip }} / {{ client.address }}</td>
              <td>{{ client.phone_number }}</td>
              <td>
                <v-btn x-small color="primary" @click="edit(client)"
                  >edit</v-btn
                >
                <v-btn x-small @click="deleteClient(client)">delete</v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>

      <!-- New Dialog -->
      <v-dialog v-model="newDialog" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="text-h6">Client Create</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Name"
                      v-model="name"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.name"
                    />
                    <v-text-field
                      label="NameKana"
                      v-model="nameKana"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.name_kana"
                    />
                    <v-text-field
                      label="email"
                      v-model="email"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.email"
                    />
                    <v-text-field
                      label="Zip"
                      v-model="zip"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.zip"
                    />
                    <v-text-field
                      label="Address"
                      v-model="address"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.address"
                    />
                    <v-text-field
                      label="TEL"
                      v-model="phoneNumber"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.phone_number"
                    />
                  </v-col>
                </v-row>

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
            <span class="text-h6">Client Edit</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Name"
                      v-model="client.name"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.name"
                    />
                    <v-text-field
                      label="NameKana"
                      v-model="client.nameKana"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.name_kana"
                    />
                    <v-text-field
                      label="email"
                      v-model="client.email"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.email"
                    />
                    <v-text-field
                      label="Zip"
                      v-model="client.zip"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.zip"
                    />
                    <v-text-field
                      label="Address"
                      v-model="client.address"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.address"
                    />
                    <v-text-field
                      label="TEL"
                      v-model="client.phoneNumber"
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.phone_number"
                    />
                  </v-col>
                </v-row>

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
            Do you want to delete the 「{{ client.name }}」 ?
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
export default {
  data() {
    return {
      greeting: '',
      alert: '',
      clients: {},
      client: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
      name: '',
      nameKana: '',
      email: '',
      zip: '',
      address: '',
      phoneNumber: '',
      storeErrors: {},
      updateErrors: {},
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

    resetNewClient() {
      this.name = ''
      this.nameKana = ''
      this.email = ''
      this.zip = ''
      this.address = ''
      this.phoneNumber = ''
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
        const result = await axios.post('/api/clients', {
          name: this.name,
          name_kana: this.nameKana,
          email: this.email,
          zip: this.zip,
          address: this.address,
          phone_number: this.phoneNumber,
        })

        if (result.status === 200) {
          this.greeting = 'Create success'
        }

        this.initClients()
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

      this.resetNewClient()
    },

    async update() {
      this.resetGreeting()

      try {
        const result = await axios.put('/api/clients/' + this.client.id, {
          name: this.client.name,
          name_kana: this.client.nameKana,
          email: this.client.email,
          zip: this.client.zip,
          address: this.client.address,
          phone_number: this.client.phoneNumber,
        })

        if (result.status === 200) {
          this.greeting = 'Update success'
        }
        this.initClients()
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
        const result = await axios.delete('/api/clients/' + this.client.id)

        if (result.status === 200) {
          this.greeting = 'Delete success'
        }

        this.initClients()
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

    async initClients() {
      const result = await axios.get('/api/clients')

      this.clients = result.data
    },

    edit(client) {
      this.client.id = client.id
      this.client.name = client.name
      this.client.nameKana = client.name_kana
      this.client.email = client.email
      this.client.zip = client.zip
      this.client.address = client.address
      this.client.phoneNumber = client.phone_number

      this.openEditModal()
    },

    async deleteClient(client) {
      this.resetGreeting()

      this.client = client

      this.openDeleteModal()
    },
  },

  created() {
    this.initClients()
  },
}
</script>
