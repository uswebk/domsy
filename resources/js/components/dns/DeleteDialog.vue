<template>
  <v-dialog v-model="open" max-width="290">
    <v-card>
      <v-card-title class="text-h5"> Deletion confirmation </v-card-title>

      <v-card-text>
        Do you want to delete the 「{{ subdomainInfo.full_domain }}」 ?
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn color="gray darken-1" text @click="close"> Close </v-btn>

        <v-btn color="red darken-1" text @click="deleteExecute"> Delete </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios'

export default {
  name: 'DeleteDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    subdomain: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {}
  },

  computed: {
    subdomainInfo() {
      return this.subdomain
    },
    open: {
      get() {
        return this.isOpen
      },
      set(value) {
        this.$emit('close', value)
      },
    },
  },

  methods: {
    close() {
      this.open = false
    },

    async deleteExecute() {
      try {
        const result = await axios.delete('/api/dns/' + this.subdomainInfo.id)

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
