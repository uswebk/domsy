<template>
  <v-dialog v-model="open" max-width="350">
    <v-card>
      <v-card-title class="text-h5"> Deletion Confirmation </v-card-title>

      <v-card-text>
        Do you want to delete the 「{{ roleModel.name }}」 ?
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn color="gray darken-1" text @click="close"> Close </v-btn>

        <v-btn color="red darken-1" text @click="deletion"> Delete </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios'

export default {
  name: 'RoleDeleteDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    role: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {}
  },

  computed: {
    roleModel() {
      return this.role
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
    close() {
      this.open = false
    },

    async deletion() {
      try {
        const result = await axios.delete('/api/roles/' + this.roleModel.id)

        this.close()

        this.$emit('sendMessage', {
          message: 'Delete Success',
          status: result.status,
        })
      } catch (error) {
        const status = error.response.status

        let alert = ''
        if (status === 403) {
          alert = 'Illegal operation was performed.'
          this.close()
        }

        if (status >= 500) {
          alert = 'Server Error'
          this.close()
        }
        this.$emit('sendMessage', {
          message: alert,
          status: status,
        })
      }
    },
  },
}
</script>
