<template>
  <v-dialog v-model="open" max-width="600px">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-toolbar color="primary" dark dense flat>
        <v-card-title class="text-subtitle-2">Account Create</v-card-title>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="accountModel.name"
                  label="Name"
                  required
                  :error-messages="errors.name"
                ></v-text-field>
                <v-text-field
                  v-model="accountModel.email"
                  label="Email"
                  required
                  :error-messages="errors.email"
                ></v-text-field>
                <v-autocomplete
                  v-model="accountModel.role_id"
                  label="Role"
                  :items="roles"
                  item-text="name"
                  item-value="id"
                  placeholder="Role Name"
                  :error-messages="errors.role_id"
                ></v-autocomplete>
                <v-text-field
                  v-model="accountModel.password"
                  :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="showPassword ? 'text' : 'password'"
                  name="password"
                  label="Password"
                  hint="At least 8 characters"
                  counter
                  required
                  :error-messages="errors.password"
                  @click:append="showPassword = !showPassword"
                ></v-text-field>
                <v-text-field
                  v-model="accountModel.password_confirmation"
                  type="password"
                  name="password_confirmation"
                  label="Confirm Password"
                  counter
                  required
                  :error-messages="errors.password_confirmation"
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
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'AccountNewDialog',
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
      showPassword: false,
      accountModel: {
        name: '',
        email: '',
        role_id: null,
        password: '',
        password_confirmation: '',
      },
      errors: {},
    }
  },
  computed: {
    ...mapGetters('role', ['roles']),
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
    ...mapActions('account', ['storeAccount', 'sendMessage']),
    close() {
      this.errors = {}
      this.resetForm()
      this.$emit('close')
    },
    resetForm() {
      this.accountModel = {
        name: '',
        email: '',
        emoji: '',
        role_id: null,
        password: '',
        password_confirmation: '',
      }
    },
    async store() {
      this.loading = true
      try {
        this.accountModel.emoji = this.$getEmoji()
        await this.storeAccount(this.accountModel)

        this.sendMessage({
          greeting: 'Account Create Success',
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
