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
          <greeting-message
            :type="greetingType"
            :message="greeting"
          ></greeting-message>

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
                <template v-slot:item="{ item }">
                  <tr
                    :style="{
                      'background-color': item.is_fixed ? '#efefef' : '',
                    }"
                  >
                    <td>{{ $dateHelper.dateHyphen(item.billing_date) }}</td>
                    <td>{{ $appHelper.formattedPriceYen(item.total) }}</td>
                    <td>
                      <v-icon
                        v-if="!item.is_fixed && canUpdateBilling"
                        @click="editBilling(item)"
                        small
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

    <billing-dialog
      :isOpen="isOpenEditBillingDialog"
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
      set(value) {
        this.errors = {}

        this.$emit('close', value)
      },
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

  methods: {
    close() {
      this.open = false
    },

    async openBillingEditDialog() {
      this.isOpenEditBillingDialog = true
    },

    async closeBillingEditDialog() {
      this.isOpenEditBillingDialog = false
    },

    async editBilling(billing) {
      this.billing.id = billing.id
      this.billing.total = billing.total
      this.billing.is_fixed = billing.is_fixed
      this.billing.billing_date = this.$dateHelper.dateHyphen(
        billing.billing_date
      )

      this.openBillingEditDialog()
    },
  },
}
</script>
