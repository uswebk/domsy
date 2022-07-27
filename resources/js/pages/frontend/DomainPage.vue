<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-database</v-icon> Domain
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

      <v-tabs v-model="tab">
        <v-tab href="#active">Active</v-tab>
        <v-tab href="#notActive">NotActive</v-tab>
        <v-tab href="#transferred">Transferred</v-tab>
        <v-tab href="#managementOnly">ManagementOnly</v-tab>
      </v-tabs>
      <v-container class="py-1"></v-container>
      <v-tabs-items v-model="tab">
        <div v-for="(_domain, index) in domains" :key="_domain.id">
          <v-tab-item :value="index">
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Price</th>
                    <th class="text-center">Active</th>
                    <th class="text-left">Purchased<br />Date</th>
                    <th class="text-left">Expired<br />Date</th>
                    <th class="text-left">Canceled<br />Date</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="domain in _domain" :key="domain.id">
                    <td>{{ domain.name }}</td>
                    <td>{{ domain.price }}</td>
                    <td class="text-center">
                      <span v-if="domain.is_active"
                        ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
                      >
                    </td>
                    <td>{{ formattedDate(domain.purchased_at) }}</td>
                    <td>{{ formattedDate(domain.expired_at) }}</td>
                    <td>{{ formattedDate(domain.canceled_at) }}</td>
                    <td>
                      <v-btn x-small color="primary" @click="edit(domain)"
                        >edit</v-btn
                      >
                      <v-btn x-small @click="deleteDomain(domain)"
                        >delete</v-btn
                      >
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-tab-item>
        </div>
      </v-tabs-items>

      <!-- New Dialog -->
      <v-dialog v-model="newDialog" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="text-h6">Domain Create</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Common Name"
                      v-model="name"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.name"
                      v-if="storeErrors.name"
                    ></p>
                    <v-select
                      v-model="registrarId"
                      :items="registrars"
                      item-text="name"
                      item-value="id"
                      label="Registrar"
                    ></v-select>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.registrar_id"
                      v-if="storeErrors.registrar_id"
                    ></p>
                    <v-text-field
                      label="Price"
                      v-model="price"
                      type="number"
                      prefix="¥"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.price"
                      v-if="storeErrors.price"
                    ></p>
                    <v-text-field
                      label="Purchased Date"
                      v-model="purchasedAt"
                      type="date"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.purchased_at"
                      v-if="storeErrors.purchased_at"
                    ></p>
                    <v-text-field
                      label="Expired Date"
                      v-model="expiredAt"
                      type="date"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.expired_at"
                      v-if="storeErrors.expired_at"
                    ></p>
                    <v-text-field
                      label="Canceled Date"
                      v-model="canceledAt"
                      type="date"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.canceled_at"
                      v-if="storeErrors.canceled_at"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="isActive"
                      label="isActive"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.is_active"
                      v-if="storeErrors.is_active"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="isTransferred"
                      label="isTransferred"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.is_transferred"
                      v-if="storeErrors.is_transferred"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="isManagementOnly"
                      label="isManagementOnly"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="storeErrors.is_management_only"
                      v-if="storeErrors.is_management_only"
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
            <span class="text-h6">Domain Edit</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Common Name"
                      v-model="domain.name"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.name"
                      v-if="updateErrors.name"
                    ></p>
                    <v-select
                      v-model="domain.registrarId"
                      :items="registrars"
                      item-text="name"
                      item-value="id"
                      label="Registrar"
                    ></v-select>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.registrar_id"
                      v-if="updateErrors.registrar_id"
                    ></p>
                    <v-text-field
                      label="Price"
                      v-model="domain.price"
                      type="number"
                      prefix="¥"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.price"
                      v-if="updateErrors.price"
                    ></p>
                    <v-text-field
                      label="Purchased Date"
                      v-model="domain.purchasedAt"
                      type="date"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.purchased_at"
                      v-if="updateErrors.purchased_at"
                    ></p>
                    <v-text-field
                      label="Expired Date"
                      v-model="domain.expiredAt"
                      type="date"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.expired_at"
                      v-if="updateErrors.expired_at"
                    ></p>
                    <v-text-field
                      label="Canceled Date"
                      v-model="domain.canceledAt"
                      type="date"
                      required
                    ></v-text-field>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.canceled_at"
                      v-if="updateErrors.canceled_at"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="domain.isActive"
                      label="isActive"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.is_active"
                      v-if="updateErrors.is_active"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="domain.isTransferred"
                      label="isTransferred"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.is_transferred"
                      v-if="updateErrors.is_transferred"
                    ></p>
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      v-model="domain.isManagementOnly"
                      label="isManagementOnly"
                    ></v-checkbox>
                    <p
                      class="red--text text-sm-body-2"
                      v-text="updateErrors.is_management_only"
                      v-if="updateErrors.is_management_only"
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

      <!-- Delete Dialog -->
      <v-dialog v-model="deleteDialog" max-width="290">
        <v-card>
          <v-card-title class="text-h5"> Deletion confirmation </v-card-title>

          <v-card-text>
            Do you want to delete the 「{{ domain.name }}」 ?
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
import { shortHyphenDate } from '../../modules/DateHelper'

export default {
  data() {
    return {
      greeting: '',
      alert: '',
      tab: '',
      domains: {
        active: {},
        notActive: {},
        managementOnly: {},
        transferred: {},
      },
      registrars: {},
      domain: {},
      newDialog: false,
      editDialog: false,
      deleteDialog: false,
      name: '',
      registrarId: '',
      price: 0,
      isActive: true,
      isTransferred: false,
      isManagementOnly: false,
      purchasedAt: '',
      expiredAt: '',
      canceledAt: '',
      storeErrors: {},
      updateErrors: {},
    }
  },

  methods: {
    async openNewModal() {
      await this.initRegistrars()

      this.newDialog = true
    },

    async openEditModal() {
      await this.initRegistrars()

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

    resetNewDomain() {
      this.name = ''
      this.registrarId = ''
      this.price = ''
      this.isActive = ''
      this.isTransferred = ''
      this.isManagementOnly = ''
      this.purchasedAt = ''
      this.expiredAt = ''
      this.canceledAt = ''
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
        const result = await axios.post('/api/domains', {
          name: this.name,
          registrar_id: this.registrarId,
          price: this.price,
          is_active: this.isActive,
          is_transferred: this.isTransferred,
          is_management_only: this.isManagementOnly,
          purchased_at: this.purchasedAt,
          expired_at: this.expiredAt,
          canceled_at: this.canceledAt,
        })

        if (result.status === 200) {
          this.greeting = 'Create success'
        }

        this.initDomains()
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

      this.resetNewDomain()
    },

    async update() {
      this.resetGreeting()

      try {
        const result = await axios.put('/api/domains/' + this.domain.id, {
          name: this.domain.name,
          registrar_id: this.domain.registrarId,
          price: this.domain.price,
          is_active: this.domain.isActive,
          is_transferred: this.domain.isTransferred,
          is_management_only: this.domain.isManagementOnly,
          purchased_at: this.domain.purchasedAt,
          expired_at: this.domain.expiredAt,
          canceled_at: this.domain.canceledAt,
        })

        if (result.status === 200) {
          this.greeting = 'Update success'
        }
        this.initDomains()
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
        const result = await axios.delete('/api/domains/' + this.domain.id)

        if (result.status === 200) {
          this.greeting = 'Delete success'
        }

        this.initDomains()
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

    async initDomains() {
      const result = await axios.get('/api/domains')

      let activeDomains = []
      let notActiveDomains = []
      let managementOnlyDomains = []
      let transferredDomains = []

      for (let key in result.data) {
        let domain = result.data[key]

        if (domain.is_transferred) {
          transferredDomains.push(domain)
        }

        if (domain.is_management_only) {
          managementOnlyDomains.push(domain)
        }

        if (domain.is_active) {
          activeDomains.push(domain)
        } else {
          notActiveDomains.push(domain)
        }
      }

      this.domains.active = activeDomains
      this.domains.transferred = transferredDomains
      this.domains.notActive = notActiveDomains
      this.domains.managementOnly = managementOnlyDomains
    },

    async initRegistrars() {
      const result = await axios.get('/api/registrars')

      this.registrars = result.data
    },

    edit(domain) {
      this.domain.id = domain.id
      this.domain.name = domain.name
      this.domain.price = domain.price
      this.domain.registrarId = domain.registrar_id
      this.domain.isActive = domain.is_active
      this.domain.isTransferred = domain.is_transferred
      this.domain.isManagementOnly = domain.is_management_only
      this.domain.purchasedAt = this.formattedDate(domain.purchased_at)
      this.domain.expiredAt = this.formattedDate(domain.expired_at)
      this.domain.canceledAt = this.formattedDate(domain.canceled_at)

      this.openEditModal()
    },

    async deleteDomain(domain) {
      this.resetGreeting()

      this.domain = domain

      this.openDeleteModal()
    },

    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },
  },

  created() {
    this.initDomains()
  },
}
</script>
