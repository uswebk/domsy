<template>
  <v-dialog v-model="open" max-width="90%">
    <v-card>
      <v-progress-linear
        v-if="loading"
        color="info"
        indeterminate
      ></v-progress-linear>
      <v-toolbar color="primary" dark dense flat>
        <v-card-title class="text-subtitle-2">Role Create</v-card-title>
      </v-toolbar>
      <div class="py-2"></div>
      <v-card-text>
        <v-form ref="form" lazy-validation>
          <v-row justify="start">
            <v-col cols="4">
              <v-row>
                <v-col>
                  <v-text-field
                    v-model="roleModel.name"
                    label="Role Name"
                    required
                    :error-messages="errors.name"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col>
                  <v-btn color="primary" @click="store">Create</v-btn>
                  <v-btn @click="close">Close</v-btn>
                </v-col>
              </v-row>
            </v-col>
            <v-divider vertical></v-divider>
            <v-col cols="8" class="px-10">
              <v-row>
                <v-col cols="12" class="py-0">
                  <v-switch
                    v-model="isAllSelect"
                    color="indigo"
                    label="All"
                    @click="toggleSwitch"
                  >
                  </v-switch>
                  <v-divider></v-divider>
                </v-col>
                <v-col
                  v-for="roleItem in roleItems"
                  :key="roleItem.id"
                  cols="3"
                >
                  <v-switch
                    v-model="roleModel.roles[roleItem.id]"
                    :label="roleItem.description"
                  >
                    <template #label
                      ><span class="text-caption font-weight-bold">
                        {{ roleItem.description }}</span
                      ></template
                    >
                  </v-switch>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-form>
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
      isAllSelect: false,
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
      this.resetForm()
      this.errors = {}
      this.$emit('close')
    },
    resetForm() {
      this.roleModel = {
        name: '',
        roles: {},
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
    toggleSwitch() {
      for (const key in this.roleItems) {
        this.roleModel.roles[this.roleItems[key].id] = this.isAllSelect
      }
    },
  },
}
</script>
