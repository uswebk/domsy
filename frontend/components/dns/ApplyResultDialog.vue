<template>
  <v-dialog v-model="open" max-width="50%">
    <v-card>
      <v-row>
        <v-col cols="6">
          <v-card class="mx-auto" flat>
            <v-card-title class="white--text green">
              Success Domain List
            </v-card-title>
            <v-divider></v-divider>
            <v-virtual-scroll
              :items="successList"
              :item-height="50"
              height="300"
            >
              <template #default="{ item }">
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>- {{ item }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-virtual-scroll>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card class="mx-auto" flat>
            <v-card-title class="white--text orange darken-4">
              Error Domain List
            </v-card-title>
            <v-divider></v-divider>
            <v-virtual-scroll :items="errorList" :item-height="50" height="300">
              <template #default="{ item }">
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>- {{ item }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-virtual-scroll>
          </v-card>
        </v-col>
      </v-row>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="light-blue" text @click="close"> Close </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DnsApplyResultDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {}
  },
  computed: {
    ...mapGetters('dns', ['applyResults']),
    successList() {
      return this.applyResults.success_list
    },
    errorList() {
      return this.applyResults.errors_list
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
  },
}
</script>
