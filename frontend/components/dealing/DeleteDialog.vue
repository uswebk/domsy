<template>
  <v-dialog v-model="open" max-width="350">
    <v-card>
      <v-toolbar color="primary" dark dense flat>
        <v-card-title class="text-subtitle-2">Confirmation</v-card-title>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <p class="font-weight-bold text-h6">
            {{ dealingModel.client.name }} /
            {{ dealingModel.domain.name }}
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
  name: 'DealingDeleteDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    dealing: {
      default: null,
      type: Object,
      required: true,
    },
  },
  computed: {
    dealingModel() {
      return this.dealing
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
    ...mapActions('dealing', ['deleteDealing', 'sendMessage']),
    close() {
      this.$emit('close')
    },
    async deletion() {
      try {
        await this.deleteDealing(this.dealingModel)

        this.sendMessage({
          greeting: 'Delete Success',
          greetingType: 'success',
        })
      } catch (error) {
        const status = error.response.status
        let message = ''
        if (status === 403) {
          message = error.response.data
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
