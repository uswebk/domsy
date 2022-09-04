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
                      'background-color': item.is_fixed ? '#efefef' : '',
                    }"
                  >
                    <td>{{ $dateHyphen(item.billing_date) }}</td>
                    <td>{{ $formattedPriceYen(item.total) }}</td>
                    <td>
                      <v-icon
                        v-if="!item.is_fixed && canUpdateBilling"
                        small
                        @click="editBilling(item)"
                      >
                        mdi-pencil
                      </v-icon>
                    </td>
                  </tr>
                </template>
              </v-data-table>
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
    <dealing-billing-dialog
      :is-open="isOpenEditBillingDialog"
      :billing="billing"
      @close="closeBillingEditDialog"
    ></dealing-billing-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

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
      isOpenEditBillingDialog: false,
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
          text: 'Action',
          value: 'action',
          sortable: false,
        },
      ],
    }
  },
  computed: {
    ...mapGetters('dealing', [
      'canUpdateBilling',
      'pageLoading',
      'greeting',
      'greetingType',
      'dealing',
    ]),
    open: {
      get() {
        return this.isOpen
      },
      set() {
        this.errors = {}
        this.close()
      },
    },
  },
  methods: {
    close() {
      this.$emit('close')
    },
    openBillingEditDialog() {
      this.isOpenEditBillingDialog = true
    },
    closeBillingEditDialog() {
      this.isOpenEditBillingDialog = false
    },
    editBilling(billing) {
      this.billing = Object.assign({}, billing)
      this.billing.billing_date = this.$dateHyphen(this.billing.billing_date)
      this.openBillingEditDialog()
    },
  },
}
</script>
