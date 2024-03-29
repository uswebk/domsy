<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-dialog v-model="overlay" fullscreen>
          <v-container id="loading" fluid fill-height>
            <v-layout justify-center align-center>
              <v-progress-circular indeterminate color="primary">
              </v-progress-circular>
            </v-layout>
          </v-container>
        </v-dialog>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-web'"
            :headline-text="'DNS'"
          ></common-icon-head-line>
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
          <v-row justify="space-between" align="end">
            <v-col cols="8">
              <v-btn
                small
                dark
                color="yellow darken-3"
                @click="openConfirmDialog"
                ><v-icon dark left> mdi-refresh </v-icon>Update DNS</v-btn
              >
              <VueJsonToCsv
                v-if="subdomains.length > 0"
                :json-data="subdomainCsv"
                :labels="labels"
                :csv-title="title"
              >
                <v-btn
                  small
                  color="light-green darken-1"
                  dark
                  @click="downloadCsv"
                >
                  <v-icon dark left> mdi-download </v-icon>
                  CSV Download
                </v-btn>
              </VueJsonToCsv>
            </v-col>
            <v-col cols="4">
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
                placeholder="Domain Name"
                @input="searchSubdomains"
              ></v-text-field>
            </v-col>
          </v-row>
          <div class="my-5"></div>
          <div v-show="length === 0">There is no data...</div>
          <v-pagination
            v-show="length"
            v-model="pageNumber"
            class="my-5"
            :length="length"
            :total-visible="10"
            @input="filterSubdomains"
          ></v-pagination>
          <div v-for="domain in subdomains" :key="domain.id" class="mb-4">
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
              <dns-list-table :subdomains="domain.subdomains"></dns-list-table>
            </v-card>
          </div>
          <v-pagination
            v-show="length"
            v-model="pageNumber"
            class="my-5"
            :length="length"
            :total-visible="10"
            @input="filterSubdomains"
          ></v-pagination>
          <dns-new-dialog
            :is-open="isOpenNewDialog"
            @close="closeNewDialog"
          ></dns-new-dialog>
          <dns-confirm-dialog
            :is-open="isOpenConfirmDialog"
            @close="closeConfirmDialog"
            @execute="applyDns"
          ></dns-confirm-dialog>
          <dns-apply-result-dialog
            :is-open="isOpenApplyResultDialog"
            @close="closeApplyResultDialog"
          ></dns-apply-result-dialog>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'
import VueJsonToCsv from 'vue-json-to-csv'

export default {
  name: 'DnsPage',
  components: {
    VueJsonToCsv,
  },
  data() {
    return {
      subdomain: {},
      subdomains: [],
      length: 0,
      isOpenNewDialog: false,
      isOpenConfirmDialog: false,
      isOpenApplyResultDialog: false,
      overlay: false,
      subdomainCsv: [],
      labels: {
        domain_name: { title: 'Domain Name' },
        dns_type: { title: 'Type' },
        priority: { title: 'Priority' },
        ttl: { title: 'TTL' },
        value: { title: 'Value' },
      },
      title: '',
    }
  },
  computed: {
    ...mapGetters('dns', [
      'dns',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
      'page',
      'pageSize',
      'searchWord',
    ]),
    pageNumber: {
      get() {
        return this.page
      },
      set(page) {
        this.pageCommit(page)
      },
    },
    limit: {
      get() {
        return this.pageSize
      },
    },
    search: {
      get() {
        return this.searchWord
      },
      set(keyword) {
        this.searchWordCommit(keyword)
      },
    },
  },
  watch: {
    dns() {
      this.filterSubdomains()
    },
  },
  created() {
    this.fetchDns()
    this.fetchDomains()
    this.fetchDnsRecordTypes()
    this.initRole()
  },
  methods: {
    ...mapMutations('dns', {
      domainIdCommit: 'domainId',
      pageCommit: 'page',
      searchWordCommit: 'searchWord',
    }),
    ...mapActions('dns', [
      'fetchDns',
      'fetchDnsRecordTypes',
      'initRole',
      'fetchDnsPaging',
      'applyRecord',
    ]),
    ...mapActions('domain', ['fetchDomains']),
    openNewDialog(domain) {
      this.domainIdCommit(domain.id)
      this.isOpenNewDialog = true
    },
    openConfirmDialog() {
      this.isOpenConfirmDialog = true
    },
    openApplyResultDialog() {
      this.isOpenApplyResultDialog = true
    },
    closeNewDialog() {
      this.isOpenNewDialog = false
    },
    closeConfirmDialog() {
      this.isOpenConfirmDialog = false
    },
    closeApplyResultDialog() {
      this.isOpenApplyResultDialog = false
    },
    filterSubdomains() {
      let dns = this.dns
      const search = this.search.trim()
      if (search !== '') {
        dns = this.dns.filter(function (subdomain) {
          return subdomain.name.includes(search)
        })
      }
      const offset = this.limit * (this.pageNumber - 1)
      const limit = this.limit * this.pageNumber
      this.length = Math.ceil(dns.length / this.pageSize)
      this.subdomains = dns.slice(offset, limit)
    },
    searchSubdomains() {
      this.pageNumber = 1
      this.filterSubdomains()
    },
    async applyDns() {
      this.closeConfirmDialog()
      this.overlay = true
      this.applyResult = await this.applyRecord()
      this.overlay = false
      this.openApplyResultDialog()
    },
    downloadCsv() {
      this.title = 'subdomain_list_' + Date.now()
      this.subdomainCsv = []
      this.subdomains.forEach((subdomain) => {
        subdomain.subdomains.forEach((dns) => {
          this.subdomainCsv.push({
            domain_name: dns.full_domain,
            dns_type: dns.dns_record_name,
            priority: dns.priority,
            ttl: dns.ttl,
            value: dns.value,
          })
        })
      })
    },
  },
}
</script>
<style scoped>
#loading {
  background-color: rgb(255 255 255 / 80%);
}
</style>
