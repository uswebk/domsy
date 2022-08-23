<template>
  <v-dialog v-model="isOpen" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6">Domain Edit</span>
      </v-card-title>
      <v-card-text>
        <v-progress-linear
          v-if="loading"
          color="info"
          indeterminate
        ></v-progress-linear>
        <v-container v-if="!loading">
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Common Name"
                  v-model="domainInfo.name"
                  hide-details
                  required
                ></v-text-field>
                <validation-error-message
                  :message="errors.name"
                ></validation-error-message>
                <v-select
                  class="mt-5"
                  v-model="domainInfo.registrar_id"
                  :items="registrars"
                  item-text="name"
                  item-value="id"
                  label="Registrar"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.registrar_id"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Price"
                  v-model="domainInfo.price"
                  type="number"
                  min="0"
                  prefix="¥"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.price"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Purchased Date"
                  v-model="domainInfo.purchased_at"
                  type="date"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.purchased_at"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Expired Date"
                  v-model="domainInfo.expired_at"
                  type="date"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.expired_at"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Canceled Date"
                  v-model="domainInfo.canceled_at"
                  type="date"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.canceled_at"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="domainInfo.is_active"
                  label="isActive"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_active"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="domainInfo.is_transferred"
                  label="isTransferred"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_transferred"
                ></validation-error-message>
              </v-col>
              <v-col cols="3">
                <v-checkbox
                  class="mt-5"
                  v-model="domainInfo.is_management_only"
                  label="isManagementOnly"
                  hide-details
                ></v-checkbox>
                <validation-error-message
                  :message="errors.is_management_only"
                ></validation-error-message>
              </v-col>
            </v-row>

            <div class="my-5"></div>

            <v-btn color="primary" @click="update">Update</v-btn>
          </v-form>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="close"> Close </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios'
import { mapActions, mapGetters, mapMutations } from 'vuex'
import ValidationErrorMessage from '../form/ValidationErrorMessage'

export default {
  name: 'UpdateDialog',
  components: {
    ValidationErrorMessage,
  },
  props: {
    domain: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      loading: true,
      registrars: {},
      errors: {},
    }
  },

  computed: {
    ...mapGetters('domain', ['isOpenEditDialog']),
    domainInfo() {
      return this.domain
    },
    isOpen: {
      get() {
        return this.isOpenEditDialog
      },
      set() {
        this.errors = {}
        this.close()
      },
    },
  },

  methods: {
    ...mapMutations('domain', {
      commitIsOpenEditDialog: 'isOpenEditDialog',
    }),
    ...mapActions('domain', ['updateDomain', 'sendMessage']),

    close() {
      this.errors = {}
      this.commitIsOpenEditDialog(false)
    },

    async update() {
      try {
        await this.updateDomain(this.domainInfo)

        this.commitIsOpenEditDialog(false)

        this.sendMessage({
          greeting: 'Update Success',
          greetingType: 'success',
        })
      } catch (error) {
        const status = error.response.status

        if (status === 422) {
          var responseErrors = error.response.data.errors
          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.errors = errors
          return
        }

        let message = ''
        if (status === 403) {
          message = 'Illegal operation was performed.'
        }

        if (status >= 500) {
          message = 'Server Error'
        }

        this.sendMessage({
          greeting: message,
          greetingType: 'alert',
        })

        this.close()
      }
    },

    async initRegistrars() {
      const result = await axios.get('/api/registrars')

      this.registrars = result.data
    },
  },

  async created() {
    this.loading = true

    await this.initRegistrars()

    this.loading = false
  },
}
</script>
