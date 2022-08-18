<template>
  <div>
    <v-dialog
      v-model="open"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="close">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title> Dealing Detail</v-toolbar-title>
        </v-toolbar>
        <v-container>
          <greeting-message
            :type="greetingType"
            :message="message"
          ></greeting-message>

          <v-card-text>
            <v-list three-line subheader>
              <v-subheader>{{ dealingModel.domain }}</v-subheader>
              <v-card-title>Billing</v-card-title>

              <div
                v-for="billing in dealingModel.domain_billings"
                :key="billing.id"
              >
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>{{
                      formattedDate(billing.billing_date)
                    }}</v-list-item-title>
                    <v-list-item-subtitle>{{
                      formattedPrice(billing.total)
                    }}</v-list-item-subtitle>
                  </v-list-item-content>
                  <v-list-item-action>
                    <v-icon
                      v-if="!billing.is_fixed && canBillingUpdate"
                      @click="editBilling(billing)"
                      small
                    >
                      mdi-pencil
                    </v-icon></v-list-item-action
                  >
                </v-list-item>
              </div>
            </v-list>
            <v-divider></v-divider>
          </v-card-text>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close"> Close </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <billing-dialog
      :isOpen="editBillingDialog"
      :billing="billing"
      @close="closeBillingEditModal"
      @sendMessage="sendMessage"
    ></billing-dialog>
  </div>
</template>

<script>
import axios from 'axios'
import GreetingMessage from '../../components/common/GreetingMessage'
import BillingDialog from '../../components/dealing/BillingDialog'
import { shortHyphenDate } from '../../modules/DateHelper'
import { priceFormat } from '../../modules/AppHelper'

export default {
  name: 'DetailDialog',
  components: {
    GreetingMessage,
    BillingDialog,
  },

  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
    dealing: {
      default: null,
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      greetingType: '',
      message: '',
      canBillingUpdate: false,
      editBillingDialog: false,
      billing: {},
    }
  },

  computed: {
    dealingModel() {
      return this.dealing
    },

    open: {
      get() {
        return this.isOpen
      },
      set(value) {
        this.errors = {}

        this.$emit('close', value)
      },
    },
  },

  methods: {
    close() {
      this.open = false
    },

    resetGreeting() {
      this.greetingType = ''
      this.message = ''
    },

    sendMessage(result) {
      this.resetGreeting()

      if (result.status === 200) {
        this.greetingType = 'success'
        this.message = result.message
      } else {
        this.greetingType = 'error'
        this.message = result.message
      }

      this.$emit('init', this.dealingModel.id)
    },

    async openBillingEditModal() {
      this.editBillingDialog = true
    },

    async closeBillingEditModal() {
      this.editBillingDialog = false
    },

    async editBilling(billing) {
      this.billing.id = billing.id
      this.billing.billingDate = this.formattedDate(billing.billing_date)
      this.billing.total = billing.total
      this.billing.isFixed = billing.is_fixed

      this.openBillingEditModal()
    },

    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },

    formattedPrice(price) {
      return priceFormat(price)
    },
  },

  async created() {
    let canBillingUpdateResult = await axios.get(
      '/api/roles/user/?has=api.dealings.updateBilling'
    )
    this.canBillingUpdate = canBillingUpdateResult.data
  },
}
</script>
