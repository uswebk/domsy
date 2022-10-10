<template>
  <v-dialog v-model="open" max-width="350">
    <v-card>
      <v-card-title></v-card-title>
      <v-card-text class="body-1">
        Client: {{ dealingModel.client.name }} <br />
        Domain: {{ dealingModel.domain.name }}
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="gray darken-1" text @click="close"> Close </v-btn>
        <v-btn color="green darken-1" text @click="deletion"> Resume </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'DealingResumeDialog',
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
    ...mapActions('dealing', ['resumeDealing', 'sendMessage']),
    close() {
      this.$emit('close')
    },
    async deletion() {
      try {
        await this.resumeDealing(this.dealingModel)

        this.sendMessage({
          greeting: 'Resume Success',
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
