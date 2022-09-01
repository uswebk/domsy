<template>
  <v-main>
    <v-container>
      <icon-head-line :icon="'mdi-web'" :headlineText="'DNS'"></icon-head-line>
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
      <div v-for="domain in dns" :key="domain.id" class="mb-4">
        <v-card>
          <v-card-title>{{ domain.name }}</v-card-title>
          <v-btn
            v-if="canStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewDialog(domain)"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>
          <list-table :subdomains="domain.subdomains"></list-table>
        </v-card>
      </div>
      <new-dialog
        :isOpen="isOpenNewDialog"
        @close="closeNewDialog"
      ></new-dialog>
    </v-container>
  </v-main>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import NewDialog from '../../components/dns/NewDialog'
import ListTable from '../../components/dns/ListTable'

export default {
  name: 'DnsPage',
  components: {
    IconHeadLine,
    GreetingMessage,
    NewDialog,
    ListTable,
  },
  data() {
    return {
      subdomain: {},
      isOpenNewDialog: false,
    }
  },
  computed: {
    ...mapGetters('dns', [
      'dns',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
  },
  methods: {
    ...mapMutations('dns', ['domainId']),
    ...mapActions('dns', ['fetchDns', 'fetchDnsRecordTypes', 'initRole']),
    ...mapActions('domain', ['fetchDomains']),

    openNewDialog(domain) {
      this.domainId(domain.id)
      this.isOpenNewDialog = true
    },

    closeNewDialog() {
      this.isOpenNewDialog = false
    },
  },
  async created() {
    this.fetchDns()
    this.fetchDomains()
    this.fetchDnsRecordTypes()
    this.initRole()
  },
}
</script>
