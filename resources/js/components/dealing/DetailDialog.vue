<template>
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
</template>

<script>
import axios from 'axios'
import { shortHyphenDate } from '../../modules/DateHelper'
import { priceFormat } from '../../modules/AppHelper'

export default {
  name: 'DetailDialog',
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
      canBillingUpdate: false,
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
