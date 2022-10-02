<template>
  <v-dialog v-model="open" max-width="350">
    <v-card :loading="loading">
      <v-card-title class="text-h6">
        <v-icon left> mdi-account-cancel </v-icon> Delete Account
      </v-card-title>
      <v-card-text>
        Relevant data will be deleted.<br />
        Do you really want to delete your account from Domsy?
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" @click="execute">Delete</v-btn>
        <v-btn color="gray darken-1" text @click="close"> Cancel </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'MypageWithdrawDialog',
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
    }
  },
  computed: {
    ...mapGetters('authentication', ['me']),
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
    ...mapActions('account', ['withdrawAccount']),
    close() {
      this.$emit('close')
    },
    async execute() {
      this.loading = true
      try {
        await this.withdrawAccount(this.me)
        this.$router.push({ path: '/login' })
      } catch (error) {
        alert('fail remove account')
      }
      this.loading = false
    },
  },
}
</script>
