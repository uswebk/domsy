<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6">Client Create</span>
      </v-card-title>
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
                  v-model="clientModel.name_kana"
                  label="NameKana"
                  required
                  :error-messages="errors.name_kana"
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
            <v-btn color="primary" @click="store">Create</v-btn>
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
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'ClientNewDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
      clientModel: {
        name: '',
        name_kana: '',
        email: '',
        zip: '',
        address: '',
        phone_number: '',
      },
      errors: {},
    }
  },
  computed: {
    ...mapGetters('client', ['pageLoading']),
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
    ...mapActions('client', ['storeClient', 'sendMessage']),
    close() {
      this.errors = {}
      this.resetForm()
      this.$emit('close')
    },
    resetForm() {
      this.clientModel = {
        name: '',
        name_kana: '',
        email: '',
        zip: '',
        address: '',
        phone_number: '',
      }
    },
    async store() {
      this.loading = true
      try {
        await this.storeClient(this.clientModel)

        this.sendMessage({
          greeting: 'Create Success',
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
      this.resetForm()
      this.loading = false
    },
  },
}
</script>
