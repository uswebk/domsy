<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-account-group'"
            :headline-text="'Client'"
          ></common-icon-head-line>
          <div class="py-5"></div>
          <common-greeting-message
            :type="greetingType"
            :message="greeting"
          ></common-greeting-message>
          <v-progress-linear
            v-show="pageLoading"
            color="yellow darken-2"
            indeterminate
            rounded
            height="6"
          ></v-progress-linear>
          <v-btn
            v-if="canStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewDialog"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>
          <client-list-table :clients="clients"></client-list-table>
          <client-new-dialog
            :is-open="isOpenNewDialog"
            @close="closeNewDialog"
          ></client-new-dialog>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'ClientPage',
  data() {
    return {
      isOpenNewDialog: false,
    }
  },
  computed: {
    ...mapGetters('client', [
      'clients',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
  },
  created() {
    this.fetchClients()
    this.initRole()
  },
  methods: {
    ...mapActions('client', ['fetchClients', 'initRole']),
    openNewDialog() {
      this.isOpenNewDialog = true
    },
    closeNewDialog() {
      this.isOpenNewDialog = false
    },
  },
}
</script>
