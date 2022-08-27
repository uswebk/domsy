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
            :message="greeting"
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
                      $dateHelper.dateHyphen(billing.billing_date)
                    }}</v-list-item-title>
                    <v-list-item-subtitle>{{
                      $appHelper.formattedPriceYen(billing.total)
                    }}</v-list-item-subtitle>
                  </v-list-item-content>
                  <v-list-item-action>
                    <v-icon
                      v-if="!billing.is_fixed && canUpdateBilling"
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
      @close="closeBillingEditDialog"
    ></billing-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import GreetingMessage from '../../components/common/GreetingMessage'
import BillingDialog from '../../components/dealing/BillingDialog'
export default {
  name: 'DealingDetailDialog',

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

  computed: {
    ...mapGetters('dealing', [
      'canUpdateBilling',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),

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

  data() {
    return {
      editBillingDialog: false,
      billing: {},
    }
  },

  methods: {
    close() {
      this.open = false
    },

    async openBillingEditDialog() {
      this.editBillingDialog = true
    },

    async closeBillingEditDialog() {
      this.editBillingDialog = false
    },

    async editBilling(billing) {
      this.billing = billing
      this.billing.billing_date = this.$dateHelper.dateHyphen(
        billing.billing_date
      )

      this.openBillingEditDialog()
    },
  },
}
</script>
