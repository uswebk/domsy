<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-account-group'"
        :headlineText="'Client'"
      ></icon-head-line>
      <div class="py-5"></div>
      <greeting-message
        :type="greetingType"
        :message="greeting"
      ></greeting-message>
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
      <list-table :clients="clients"></list-table>
      <new-dialog
        :isOpen="isOpenNewDialog"
        @close="closeNewDialog"
      ></new-dialog>
    </v-container>
  </v-main>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import ListTable from '../../components/client/ListTable'
import NewDialog from '../../components/client/NewDialog'

export default {
  name: 'ClientPage',
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    NewDialog,
  },
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
  methods: {
    ...mapActions('client', ['fetchClients', 'initRole']),

    openNewDialog() {
      this.isOpenNewDialog = true
    },

    closeNewDialog() {
      this.isOpenNewDialog = false
    },
  },
  created() {
    this.fetchClients()
    this.initRole()
  },
}
</script>
