<template>
  <v-dialog v-model="open" max-width="90%">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-card-title class="pl-8">
        <span class="text-h6">Role Create</span>
      </v-card-title>
      <v-card-text>
        <v-container v-if="!loading">
          <v-form ref="form" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="roleModel.name"
                  label="Role Name"
                  required
                  :error-messages="errors.name"
                ></v-text-field>
              </v-col>
              <div class="my-10"></div>
              <v-col v-for="roleItem in roleItems" :key="roleItem.id" cols="6">
                <v-switch
                  v-model="roleModel.roles[roleItem.id]"
                  :label="roleItem.description"
                >
                </v-switch>
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
  name: 'RoleNewDialog',
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
      roleModel: {
        name: '',
        roles: {},
      },
      errors: {},
    }
  },
  computed: {
    ...mapGetters('role', ['roleItems']),
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
    ...mapActions('account', ['sendMessage']),
    ...mapActions('role', ['storeRole']),
    close() {
      this.errors = {}
      this.$emit('close')
    },
    resetForm() {
      this.roleModel = {
        name: '',
        roles: [],
      }
    },
    async store() {
      this.loading = true
      try {
        await this.storeRole(this.roleModel)

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
      this.resetForm()
      this.close()
      this.loading = false
    },
  },
}
</script>
