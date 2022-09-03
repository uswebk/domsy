<template>
  <v-dialog v-model="open" max-width="350">
    <v-card>
      <v-card-title class="text-h5"> Deletion Confirmation </v-card-title>
      <v-card-text>
        <p class="font-weight-bold text-h6">{{ accountModel.name }}</p>
        Do you want to delete the ?
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
  name: 'AccountDeleteDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    account: {
      default: null,
      type: Object,
      required: true,
    },
  },
  computed: {
    accountModel() {
      return this.account
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
    ...mapActions('account', ['deleteAccount', 'sendMessage']),
    close() {
      this.$emit('close')
    },
    async deletion() {
      try {
        await this.deleteAccount(this.accountModel)

        this.sendMessage({
          greeting: 'Delete Success',
          greetingType: 'success',
        })
      } catch (error) {
        const status = error.response.status
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
    },
  },
}
</script>
