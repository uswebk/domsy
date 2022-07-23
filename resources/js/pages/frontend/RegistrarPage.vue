<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-domain</v-icon> Registrar
      </h1>

      <div class="py-5"></div>
      <v-alert dense text type="success" v-if="greeting">{{
        greeting
      }}</v-alert>
      <v-alert dense text type="error" v-if="alert">{{ alert }}</v-alert>

      <v-btn class="ma-2" color="primary" small @click="openNewModal">
        <v-icon dark left> mdi-plus-circle </v-icon>New
      </v-btn>

      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">Name</th>
              <th class="text-left">Link</th>
              <th class="text-left">Note</th>
              <th class="text-left">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registrar in registrars" :key="registrar.id">
              <td>{{ registrar.name }}</td>
              <td>
                <a :href="registrar.link" target="_blank">{{
                  registrar.link
                }}</a>
              </td>
              <td>{{ registrar.note }}</td>
              <td>
                <v-btn x-small color="primary" @click="edit(registrar)"
                  >edit</v-btn
                >
                <v-btn x-small>delete</v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>

      <!-- NewDialog -->
      <v-dialog v-model="newDialog" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="text-h6">Registrar Create</span>
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
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.name"
                      v-if="storeErrors.name"
                    ></p>

                    <v-text-field
                      label="Link"
                      v-model="link"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.link"
                      v-if="storeErrors.link"
                    ></p>

                    <v-textarea
                      label="Note"
                      v-model="note"
                      required
                    ></v-textarea>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.note"
                      v-if="storeErrors.note"
                    ></p>
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
            <span class="text-h6">Registrar Edit</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Name"
                      v-model="registrar.name"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.name"
                      v-if="updateErrors.name"
                    ></p>

                    <v-text-field
                      label="Link"
                      v-model="registrar.link"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.link"
                      v-if="updateErrors.link"
                    ></p>

                    <v-textarea
                      label="Note"
                      v-model="registrar.note"
                      required
                    ></v-textarea>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.note"
                      v-if="updateErrors.note"
                    ></p>
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
      registrars: {},
      registrar: {},
      newDialog: false,
      editDialog: false,
      name: '',
      link: '',
      note: '',
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

    closeNewModal() {
      this.resetStoreError()
      this.newDialog = false
    },

    closeEditModal() {
      this.resetUpdateError()
      this.editDialog = false
    },

    resetNewRegistrar() {
      this.name = ''
      this.link = ''
      this.note = ''
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
        const result = await axios.post('/api/registrars', {
          name: this.name,
          link: this.link,
          note: this.note,
        })

        if (result.status === 200) {
          this.greeting = 'Create success'
        }

        this.initRegistrars()
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

      this.resetNewRegistrar()
    },

    async update() {
      this.resetGreeting()

      try {
        const result = await axios.put('/api/registrars/' + this.registrar.id, {
          name: this.registrar.name,
          link: this.registrar.link,
          note: this.registrar.note,
        })

        if (result.status === 200) {
          this.greeting = 'Update success'
        }
        this.initRegistrars()
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

    async initRegistrars() {
      const result = await axios.get('/api/registrars')

      this.registrars = result.data
    },

    edit(registrar) {
      this.registrar.id = registrar.id
      this.registrar.name = registrar.name
      this.registrar.link = registrar.link
      this.registrar.note = registrar.note

      this.openEditModal()
    },
  },

  created() {
    this.initRegistrars()
  },
}
</script>
