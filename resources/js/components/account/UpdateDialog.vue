<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-card-title class="pl-8">
        <span class="text-h6"> Account Edit</span>
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
                  class="mt-5"
                  label="Name"
                  v-model="accountModel.name"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.name"
                ></validation-error-message>

                <v-text-field
                  class="mt-5"
                  label="Email"
                  v-model="accountModel.email"
                  required
                  hide-details
                ></v-text-field>
                <validation-error-message
                  :message="errors.email"
                ></validation-error-message>

                <v-select
                  class="mt-5"
                  v-model="accountModel.roleId"
                  :items="roles"
                  item-text="name"
                  item-value="id"
                  label="Role"
                  hide-details
                ></v-select>
                <validation-error-message
                  :message="errors.role_id"
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
import ValidationErrorMessage from '../form/ValidationErrorMessage'

export default {
  name: 'UpdateDialog',
  components: {
    ValidationErrorMessage,
  },
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    account: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      loading: true,
      roles: [],
      errors: {},
    }
  },

  computed: {
    accountModel() {
      return this.account
    },
    open: {
      get() {
        return this.isOpen
      },
      set(value) {
        this.errors = {}
        this.$emit('close', value)
      },
    },
  },

  methods: {
    async update() {
      try {
        const result = await axios.put(
          '/api/accounts/' + this.accountModel.id,
          {
            name: this.accountModel.name,
            role_id: this.accountModel.roleId,
            email: this.accountModel.email,
          }
        )

        this.close()

        this.$emit('sendMessage', {
          message: 'Update success',
          status: result.status,
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
          this.close()
        }

        if (status >= 500) {
          message = 'Server Error'
          this.close()
        }

        this.$emit('sendMessage', {
          message: message,
          status: status,
        })
      }
    },

    close() {
      this.open = false
    },

    async initRoles() {
      const result = await axios.get('api/roles')

      this.roles = result.data
    },
  },

  async created() {
    this.loading = true

    this.initRoles()

    this.loading = false
  },
}
</script>
