<template>
  <v-dialog v-model="open" max-width="350">
    <v-card>
      <v-card-title class="text-h5"> Deletion Confirmation </v-card-title>

      <v-card-text>
        <p class="font-weight-bold text-h6">{{ domainModel.name }}</p>
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
  name: 'DeleteDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    domain: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {}
  },

  computed: {
    domainModel() {
      return this.domain
    },
    open: {
      get() {
        return this.isOpen
      },
      set() {
        this.errors = {}
        this.close()
      },
    },
  },

  methods: {
    ...mapActions('domain', ['deleteDomain', 'sendMessage']),

    close() {
      this.$emit('close')
    },

    async deletion() {
      try {
        await this.deleteDomain(this.domainModel)

        this.close()

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
          greetingType: 'alert',
        })

        this.close()
      }
    },
  },
}
</script>
