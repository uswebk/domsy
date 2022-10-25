<template>
  <v-dialog v-model="open" max-width="350">
    <v-card>
      <v-toolbar color="primary" dark dense flat>
        <v-card-title class="text-h6">DNS All Update</v-card-title>
      </v-toolbar>
      <v-card-text>
        <v-container>
          Apply DNS record information? <br />
          It may take some time depending on the number of cases.<br />
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" @click="execute">Execute</v-btn>
        <v-btn color="gray darken-1" text @click="close"> Close </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'DnsConfirmDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
  },
  computed: {
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
    close() {
      this.$emit('close')
    },
    execute() {
      this.$emit('execute')
    },
  },
}
</script>
