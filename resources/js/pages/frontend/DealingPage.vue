<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-note-edit'"
        :headlineText="'Dealing'"
      ></icon-head-line>

      <div class="py-5"></div>

      <greeting-message
        :type="greetingType"
        :message="message"
      ></greeting-message>

      <v-progress-linear
        v-show="!finishInitialize"
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
        @click="openNewModal()"
      >
        <v-icon dark left> mdi-plus-circle </v-icon>New
      </v-btn>

      <v-tabs v-model="tab">
        <v-tab href="#active">Active</v-tab>
        <v-tab href="#stop">Stop</v-tab>
      </v-tabs>
      <v-container class="py-1"></v-container>
      <v-tabs-items v-model="tab">
        <div v-for="(_dealing, index) in dealings" :key="_dealing.id">
          <v-tab-item :value="index">
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Domain Name</th>
                    <th class="text-left">Client Name</th>
                    <th class="text-left">Subtotal</th>
                    <th class="text-left">Discount</th>
                    <th class="text-left">First Billing Date</th>
                    <th class="text-left">Interval</th>
                    <th class="text-center">Auto Update</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="dealing in _dealing" :key="dealing.id">
                    <td>{{ dealing.domain }}</td>
                    <td>{{ dealing.client.name }}</td>
                    <td>{{ formattedPrice(dealing.subtotal) }}</td>
                    <td>{{ formattedPrice(dealing.discount) }}</td>
                    <td>{{ formattedDate(dealing.billing_date) }}</td>
                    <td>
                      {{ dealing.interval }} {{ dealing.interval_category }}
                    </td>
                    <td class="text-center">
                      <span v-if="dealing.is_auto_update"
                        ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
                      >
                    </td>
                    <td>
                      <v-btn
                        v-if="canUpdate"
                        x-small
                        color="primary"
                        @click="edit(dealing)"
                        >edit</v-btn
                      >
                      <v-btn
                        v-if="canDetail"
                        x-small
                        color="primary"
                        @click="detail(dealing)"
                        >detail</v-btn
                      >
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-tab-item>
        </div>
      </v-tabs-items>

      <new-dialog
        :isOpen="newDialog"
        @close="closeNewModal"
        @sendMessage="sendMessage"
      ></new-dialog>

      <update-dialog
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
      ></detail-dialog>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import NewDialog from '../../components/dealing/NewDialog'
import UpdateDialog from '../../components/dealing/UpdateDialog'
import DetailDialog from '../../components/dealing/DetailDialog'
import { shortHyphenDate } from '../../modules/DateHelper'
import { priceFormat } from '../../modules/AppHelper'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    NewDialog,
    UpdateDialog,
    DetailDialog,
  },

  data() {
    return {
      greetingType: '',
      message: '',
      tab: '',
      finishInitialize: false,
      canStore: false,
      canUpdate: false,
      canDetail: false,
      dealings: {
        active: {},
        stop: {},
      },
      dealing: {},
      newDialog: false,
      editDialog: false,
      detailDialog: false,
    }
  },

  methods: {
    async openNewModal() {
      this.newDialog = true
    },

    async openEditModal() {
      this.editDialog = true
    },

    openDetailModal() {
      this.detailDialog = true
    },

    closeNewModal() {
      this.newDialog = false
    },

    closeEditModal() {
      this.resetUpdateError()
      this.editDialog = false
    },

    closeDetailModal() {
      this.detailDialog = false
    },

    resetGreeting() {
      this.greetingType = ''
      this.message = ''
    },

    sendMessage(result) {
      this.resetGreeting()

      this.initDealings()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
      }
    },

    async initDealing(dealingId) {
      const result = await axios.get('/api/dealings/' + dealingId)

      this.dealing = result.data
    },

    async initDealings() {
      this.finishInitialize = false

      const result = await axios.get('/api/dealings')

      let dealings_actives = []
      let dealings_stops = []
      for (let key in result.data) {
        for (let key2 in result.data[key].domain_dealings) {
          let dealing = result.data[key].domain_dealings[key2]
          dealing.domain = result.data[key].name

          if (dealing.is_halt) {
            dealings_stops.push(dealing)
          } else {
            dealings_actives.push(dealing)
          }
        }
      }

      this.dealings.active = dealings_actives
      this.dealings.stop = dealings_stops

      this.finishInitialize = true
    },

    async initRoleOperation() {
      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.dealings.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDetailResult = await axios.get(
        '/api/roles/user/?has=api.dealings.detail'
      )
      this.canDetail = canDetailResult.data

      this.finishInitialize = true
    },

    async edit(dealing) {
      this.dealing.id = dealing.id
      this.dealing.domainId = dealing.domain_id
      this.dealing.clientId = dealing.client_id
      this.dealing.subtotal = dealing.subtotal
      this.dealing.discount = dealing.discount
      this.dealing.billingDate = this.formattedDate(dealing.billing_date)
      this.dealing.interval = dealing.interval
      this.dealing.intervalCategory = dealing.interval_category
      this.dealing.isAutoUpdate = dealing.is_auto_update
      this.dealing.isHalt = dealing.is_halt

      this.openEditModal()
    },

    async detail(dealing) {
      this.dealing = dealing

      this.openDetailModal()
    },

    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },

    formattedPrice(price) {
      return priceFormat(price)
    },
  },

  created() {
    this.initDealings()
    this.initRoleOperation()
  },
}
</script>
