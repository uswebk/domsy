<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-toolbar color="primary" dark dense flat>
        <v-card-title class="text-subtitle-2">Client Edit</v-card-title>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="clientModel.name"
                  label="Name"
                  required
                  :error-messages="errors.name"
                ></v-text-field>
                <v-text-field
                  v-model="clientModel.email"
                  label="email"
                  required
                  :error-messages="errors.email"
                ></v-text-field>
                <v-text-field
                  v-model="clientModel.zip"
                  label="Zip"
                  required
                  :error-messages="errors.zip"
                ></v-text-field>
                <v-text-field
                  v-model="clientModel.address"
                  label="Address"
                  required
                  :error-messages="errors.address"
                ></v-text-field>
                <v-text-field
                  v-model="clientModel.phone_number"
                  label="TEL"
                  required
                  :error-messages="errors.phone_number"
                ></v-text-field>
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
import { mapActions } from 'vuex'

export default {
  name: 'ClientUpdateDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    client: {
      default: null,
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
      errors: {},
    }
  },
  computed: {
    clientModel() {
      return this.client
    },
    open: {
      get() {
        return this.isOpen
      },
      set() {
        this.close()
      },
    },
  },
  methods: {
    ...mapActions('client', ['updateClient', 'sendMessage']),
    close() {
      this.errors = {}
      this.$emit('close')
    },
    async update() {
      this.loading = true
      try {
        await this.updateClient(this.clientModel)

        this.sendMessage({
          greeting: 'Update Success',
          greetingType: 'success',
        })
      } catch (error) {
        const status = error.response.status

        if (status === 422) {
          const errors = error.response.data.errors
          const _errors = {}
          for (const key in errors) {
            _errors[key] = errors[key][0]
          }
          this.errors = _errors
          this.loading = false
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
          greetingType: 'error',
        })
      }
      this.close()
      this.loading = false
    },
  },
}
</script>
