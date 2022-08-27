<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-handshake'"
        :headlineText="'Dealing'"
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
        @click="openNewDialog()"
      >
        <v-icon dark left> mdi-plus-circle </v-icon>New
      </v-btn>

      <v-tabs v-model="tab">
        <v-tab v-for="(tab, index) in tabs" :key="index" :href="'#' + tab">{{
          tab
        }}</v-tab>
      </v-tabs>

      <v-container class="py-1"></v-container>

      <v-tabs-items v-model="tab">
        <div v-for="(dealing, index) in dealings" :key="dealing.id">
          <v-tab-item :value="index">
            <list-table :dealings="dealing"></list-table>
          </v-tab-item>
        </div>
      </v-tabs-items>

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
import ListTable from '../../components/dealing/ListTable'
import NewDialog from '../../components/dealing/NewDialog'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    NewDialog,
  },

  computed: {
    ...mapGetters('dealing', [
      'dealings',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
    tabs() {
      return Object.keys(this.dealings)
    },
  },

  data() {
    return {
      tab: '',
      dealing: {},
      isOpenNewDialog: false,
    }
  },

  methods: {
    ...mapActions('dealing', ['fetchDealings', 'initRole']),
    ...mapActions('domain', ['fetchDomains']),
    ...mapActions('client', ['fetchClients']),

    async openNewDialog() {
      this.isOpenNewDialog = true
    },

    closeNewDialog() {
      this.isOpenNewDialog = false
    },
  },

  created() {
    this.fetchDealings()
    this.fetchDomains()
    this.fetchClients()
    this.initRole()
  },
}
</script>
