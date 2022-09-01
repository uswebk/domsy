<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6">Client Edit</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Name"
                  v-model="clientModel.name"
                  required
                  :error-messages="errors.name"
                ></v-text-field>
                <v-text-field
                  label="NameKana"
                  v-model="clientModel.name_kana"
                  required
                  :error-messages="errors.name_kana"
                ></v-text-field>
                <v-text-field
                  label="email"
                  v-model="clientModel.email"
                  required
                  :error-messages="errors.email"
                ></v-text-field>
                <v-text-field
                  label="Zip"
                  v-model="clientModel.zip"
                  required
                  :error-messages="errors.zip"
                ></v-text-field>
                <v-text-field
                  label="Address"
                  v-model="clientModel.address"
                  required
                  :error-messages="errors.address"
                ></v-text-field>
                <v-text-field
                  label="TEL"
                  v-model="clientModel.phone_number"
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
          for (let key in errors) {
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
