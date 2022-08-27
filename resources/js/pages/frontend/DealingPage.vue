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

      <new-dialog :isOpen="isOpenNewDialog" @close="closeNewModal"></new-dialog>

      <!-- <update-dialog
        :isOpen="editDialog"
        :dealing="dealing"
        @close="closeEditModal"
        @sendMessage="sendMessage"
      ></update-dialog>

      <detail-dialog
        :isOpen="detailDialog"
        :dealing="dealing"
        @close="closeDetailModal"
        @init="initDealing"
        @sendMessage="sendMessage"
      ></detail-dialog> -->
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import ListTable from '../../components/dealing/ListTable'
import NewDialog from '../../components/dealing/NewDialog'
// import UpdateDialog from '../../components/dealing/UpdateDialog'
// import DetailDialog from '../../components/dealing/DetailDialog'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    NewDialog,
    // UpdateDialog,
    // DetailDialog,
  },

  computed: {
    ...mapGetters('dealing', [
      'dealings',
      'tabs',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
  },

  data() {
    return {
      tab: '',
      dealing: {},
      // dealings2: {
      //   active: [],
      //   stop: [],
      // },
      isOpenNewDialog: false,
      // editDialog: false,
      // detailDialog: false,
    }
  },

  methods: {
    ...mapActions('dealing', ['fetchDealings', 'initRole']),

    async openNewDialog() {
      this.isOpenNewDialog = true
    },

    // async openEditModal() {
    //   this.editDialog = true
    // },

    // openDetailModal() {
    //   this.detailDialog = true
    // },

    closeNewDialog() {
      this.isOpenNewDialog = false
    },

    // closeEditModal() {
    //   this.editDialog = false
    // },

    // closeDetailModal() {
    //   this.detailDialog = false
    // },

    // resetGreeting() {
    //   this.greetingType = ''
    //   this.message = ''
    // },

    // sendMessage(result) {
    //   this.resetGreeting()

    //   this.initDealings()

    //   if (result.status === 200) {
    //     this.greetingType = 'success'
    //     this.message = result.message
    //   } else {
    //     this.greetingType = 'error'
    //     this.message = result.message
    //   }
    // },

    async initDealing(dealingId) {
      const result = await axios.get('/api/dealings/' + dealingId)

      this.dealing = result.data
    },

    // async initDealings() {
    //   this.finishInitialize = false

    //   const result = await axios.get('/api/dealings')

    //   let dealings_actives = []
    //   let dealings_stops = []
    //   for (let key in result.data) {
    //     for (let key2 in result.data[key].domain_dealings) {
    //       let dealing = result.data[key].domain_dealings[key2]
    //       dealing.domain = result.data[key].name

    //       if (dealing.is_halt) {
    //         dealings_stops.push(dealing)
    //       } else {
    //         dealings_actives.push(dealing)
    //       }
    //     }
    //   }

    //   this.dealings2.active = dealings_actives
    //   this.dealings2.stop = dealings_stops

    //   this.finishInitialize = true
    // },

    // async initRoleOperation() {
    //   let canStoreResult = await axios.get(
    //     '/api/roles/user/?has=api.dealings.store'
    //   )
    //   this.canStore = canStoreResult.data

    //   this.finishInitialize = true
    // },

    // async edit(dealing) {
    //   this.dealing.id = dealing.id
    //   this.dealing.domainId = dealing.domain_id
    //   this.dealing.clientId = dealing.client_id
    //   this.dealing.subtotal = dealing.subtotal
    //   this.dealing.discount = dealing.discount
    //   this.dealing.billingDate = this.formattedDate(dealing.billing_date)
    //   this.dealing.interval = dealing.interval
    //   this.dealing.intervalCategory = dealing.interval_category
    //   this.dealing.isAutoUpdate = dealing.is_auto_update
    //   this.dealing.isHalt = dealing.is_halt

    //   this.openEditModal()
    // },

    // async detail(dealing) {
    //   this.dealing = dealing

    //   this.openDetailModal()
    // },

    // formattedDate(dateTime) {
    //   return shortHyphenDate(dateTime)
    // },

    // formattedPrice(price) {
    //   return priceFormat(price)
    // },
  },

  created() {
    this.fetchDealings()
    this.initRole()
  },
}
</script>
