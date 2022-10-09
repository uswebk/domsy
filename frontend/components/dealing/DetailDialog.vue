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
          <v-toolbar-title> {{ dealing.domain.name }}</v-toolbar-title>
        </v-toolbar>
        <v-container>
          <common-greeting-message
            :type="greetingType"
            :message="greeting"
          ></common-greeting-message>
          <v-card-text>
            <v-list three-line subheader>
              <v-card-title>Billings</v-card-title>
              <v-card-actions
                v-if="canStoreBilling && !isHalt"
                style="height: 50px; position: relative"
              >
                <v-btn
                  fab
                  absolute
                  top
                  right
                  color="primary"
                  small
                  @click="openBillingNewDialog"
                >
                  <v-icon>mdi-plus</v-icon>
                </v-btn>
              </v-card-actions>
              <v-data-table
                :headers="headers"
                :items="dealing.domain_billings"
                :sort-by="'billing_date'"
                :sort-desc="true"
                hide-default-footer
                dense
              >
                <template #item="{ item }">
                  <tr
                    :style="{
                      'background-color': item.is_fixed ? 'linen' : '',
                    }"
                  >
                    <td>{{ $dateHyphen(item.billing_date) }}</td>
                    <td>{{ $formattedPriceYen(item.total) }}</td>
                    <td>
                      <v-chip
                        :color="getBillingStatusColor(item)"
                        text-color="white"
                        small
                      >
                        {{ getBillingStatus(item) }}
                      </v-chip>
                    </td>
                    <td>
                      <v-tooltip
                        v-if="!item.is_fixed && canUpdateBilling"
                        bottom
                      >
                        <template #activator="{ on, attrs }">
                          <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon small @click="editBilling(item)">
                              mdi-pencil
                            </v-icon>
                          </v-btn>
                        </template>
                        <span>Edit</span>
                      </v-tooltip>
                      <v-tooltip v-if="!item.canceled_at" bottom>
                        <template #activator="{ on, attrs }">
                          <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon small @click="cancelBilling(item)">
                              mdi-cancel
                            </v-icon>
                          </v-btn>
                        </template>
                        <span>Cancel</span>
                      </v-tooltip>
                    </td>
                  </tr>
                </template>
              </v-data-table>
            </v-list>
            <v-divider></v-divider>
          </v-card-text>
        </v-container>
      </v-card>
    </v-dialog>
    <dealing-billing-new-dialog
      :is-open="isOpenNewBillingDialog"
      @close="closeBillingNewDialog"
    ></dealing-billing-new-dialog>
    <dealing-billing-update-dialog
      :is-open="isOpenEditBillingDialog"
      :billing="billing"
      @close="closeBillingEditDialog"
    ></dealing-billing-update-dialog>
    <dealing-billing-cancel-dialog
      :is-open="isOpenCancelBillingDialog"
      :billing="billing"
      @close="closeBillingCancelDialog"
    ></dealing-billing-cancel-dialog>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DealingDetailDialog',
  props: {
    isOpen: {
      default: false,
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      isOpenNewBillingDialog: false,
      isOpenEditBillingDialog: false,
      isOpenCancelBillingDialog: false,
      billing: {},
      headers: [
        {
          text: 'Billing Date',
          value: 'billing_date',
        },
        {
          text: 'Amount',
          value: 'total',
        },
        {
          text: 'Status',
          value: 'status',
        },
        {
          text: 'Action',
          value: 'action',
          sortable: false,
        },
      ],
    }
  },
  computed: {
    ...mapGetters('dealing', [
      'canStoreBilling',
      'canUpdateBilling',
      'pageLoading',
      'greeting',
      'greetingType',
      'dealing',
    ]),
    open: {
      get() {
        this.initMessage()
        return this.isOpen
      },
      set() {
        this.errors = {}
        this.close()
      },
    },
    isHalt() {
      return this.dealing.is_halt
    },
  },
  methods: {
    ...mapActions('dealing', ['initMessage']),
    close() {
      this.$emit('close')
    },
    openBillingNewDialog() {
      this.isOpenNewBillingDialog = true
    },
    closeBillingNewDialog() {
      this.isOpenNewBillingDialog = false
    },
    openBillingEditDialog() {
      this.isOpenEditBillingDialog = true
    },
    closeBillingEditDialog() {
      this.isOpenEditBillingDialog = false
    },
    openBillingCancelDialog() {
      this.isOpenCancelBillingDialog = true
    },
    closeBillingCancelDialog() {
      this.isOpenCancelBillingDialog = false
    },
    editBilling(billing) {
      this.billing = Object.assign({}, billing)
      this.billing.billing_date = this.$dateHyphen(this.billing.billing_date)
      this.openBillingEditDialog()
    },
    cancelBilling(billing) {
      this.billing = Object.assign({}, billing)
      this.openBillingCancelDialog()
    },
    getBillingStatus(billing) {
      if (billing.canceled_at !== null) {
        return 'cancel'
      }

      if (billing.is_fixed) {
        return 'fixed'
      }

      return 'valid'
    },
    getBillingStatusColor(billing) {
      if (billing.canceled_at !== null) {
        return 'red'
      }

      if (billing.is_fixed) {
        return 'green'
      }

      return 'primary'
    },
  },
}
</script>
