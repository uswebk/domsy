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

      <v-progress-linear
        v-show="!finishInitialize"
        color="yellow darken-2"
        indeterminate
        rounded
        height="6"
      ></v-progress-linear>

      <v-btn
        v-if="canStore"
        class="ma-2"
        color="primary"
        small
        @click="openNewModal"
      >
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
                      <v-btn
                        v-if="canUpdate"
                        x-small
                        color="primary"
                        @click="edit(domain)"
                        >edit</v-btn
                      >
                      <v-btn
                        v-if="canDelete"
                        x-small
                        @click="deleteDomain(domain)"
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
          <v-card-title class="pl-8">
            <span class="text-h6">Domain Create</span>
          </v-card-title>
          <v-card-text>
            <v-progress-linear
              v-if="dialogLoading"
              color="info"
              indeterminate
            ></v-progress-linear>
            <v-container v-if="!dialogLoading">
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Common Name"
                      v-model="name"
                      hide-details
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.name"
                    />
                    <v-select
                      class="mt-5"
                      v-model="registrarId"
                      :items="registrars"
                      item-text="name"
                      item-value="id"
                      label="Registrar"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.registrar_id"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Price"
                      v-model="price"
                      type="number"
                      prefix="¥"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.price"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Purchased Date"
                      v-model="purchasedAt"
                      type="date"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.purchased_at"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Expired Date"
                      v-model="expiredAt"
                      type="date"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.expired_at"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Canceled Date"
                      v-model="canceledAt"
                      type="date"
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.canceled_at"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="isActive"
                      label="isActive"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.is_active"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="isTransferred"
                      label="isTransferred"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.is_transferred"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="isManagementOnly"
                      label="isManagementOnly"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessageComponent
                      :message="storeErrors.is_management_only"
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
          <v-card-title class="pl-8">
            <span class="text-h6">Domain Edit</span>
          </v-card-title>
          <v-card-text>
            <v-progress-linear
              v-if="dialogLoading"
              color="info"
              indeterminate
            ></v-progress-linear>
            <v-container v-if="!dialogLoading">
              <v-form ref="form" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Common Name"
                      v-model="domain.name"
                      hide-details
                      required
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.name"
                    />
                    <v-select
                      class="mt-5"
                      v-model="domain.registrarId"
                      :items="registrars"
                      item-text="name"
                      item-value="id"
                      label="Registrar"
                      hide-details
                    ></v-select>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.registrar_id"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Price"
                      v-model="domain.price"
                      type="number"
                      prefix="¥"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.price"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Purchased Date"
                      v-model="domain.purchasedAt"
                      type="date"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.purchased_at"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Expired Date"
                      v-model="domain.expiredAt"
                      type="date"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.expired_at"
                    />
                    <v-text-field
                      class="mt-5"
                      label="Canceled Date"
                      v-model="domain.canceledAt"
                      type="date"
                      required
                      hide-details
                    ></v-text-field>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.canceled_at"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="domain.isActive"
                      label="isActive"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.is_active"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="domain.isTransferred"
                      label="isTransferred"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.is_transferred"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-checkbox
                      class="mt-5"
                      v-model="domain.isManagementOnly"
                      label="isManagementOnly"
                      hide-details
                    ></v-checkbox>
                    <ValidationErrorMessageComponent
                      :message="updateErrors.is_management_only"
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
import ValidationErrorMessageComponent from '../../components/form/ValidationErrorMessageComponent'

export default {
  components: {
    ValidationErrorMessageComponent,
  },

  data() {
    return {
      greeting: '',
      alert: '',
      finishInitialize: false,
      dialogLoading: false,
      tab: '',
      canStore: false,
      canUpdate: false,
      canDelete: false,
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
      this.dialogLoading = true
      this.newDialog = true

      await this.initRegistrars()

      this.dialogLoading = false
    },

    async openEditModal() {
      this.dialogLoading = true
      this.editDialog = true

      await this.initRegistrars()

      this.dialogLoading = false
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
        this.resetNewDomain()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeNewModal()
          this.resetNewDomain()
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
          this.resetNewDomain()
        }
      }
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

    async initRoleOperation() {
      let canStoreResult = await axios.get(
        '/api/roles/user/?has=api.domains.store'
      )
      this.canStore = canStoreResult.data

      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.domains.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDeleteResult = await axios.get(
        '/api/roles/user/?has=api.domains.delete'
      )
      this.canDelete = canDeleteResult.data

      this.finishInitialize = true
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
    this.initRoleOperation()
  },
}
</script>
