<template>
  <v-dialog v-model="open" max-width="290">
    <v-card>
      <v-toolbar color="primary" dark dense flat>
        <v-card-title class="text-subtitle-2">Confirmation</v-card-title>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <p class="font-weight-bold text-h6">
            {{ subdomainModel.full_domain }}
          </p>
          <v-divider class="mb-3"></v-divider>
          Do you want to delete ?
        </v-container>
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
import { mapActions } from 'vuex'

export default {
  name: 'DnsDeleteDialog',
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
  computed: {
    subdomainModel() {
      return this.subdomain
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
    ...mapActions('dns', ['deleteDns', 'sendMessage']),
    close() {
      this.$emit('close')
    },
    async deletion() {
      try {
        await this.deleteDns(this.subdomainModel)

        this.sendMessage({
          greeting: 'Delete Success',
          greetingType: 'success',
        })
      } catch (error) {
        let message = ''
        const status = error.response.status
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
    },
  },
}
</script>
