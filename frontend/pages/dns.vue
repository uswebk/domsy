<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-web'"
            :headline-text="'DNS'"
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
          <v-row justify="end">
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
          <v-pagination
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
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'

export default {
  name: 'DnsPage',
  data() {
    return {
      subdomain: {},
      subdomains: [],
      length: 0,
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
    ]),
    ...mapActions('domain', ['fetchDomains']),
    openNewDialog(domain) {
      this.domainIdCommit(domain.id)
      this.isOpenNewDialog = true
    },
    closeNewDialog() {
      this.isOpenNewDialog = false
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
  },
}
</script>
