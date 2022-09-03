<template>
  <div>
    <v-row justify="end">
      <v-col cols="4">
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <div class="my-2"></div>
    <v-data-table :headers="headers" :items="dealings" :search="search">
      <template #[`item.subtotal`]="{ item }">
        {{ $formattedPriceYen(item.subtotal) }}
      </template>
      <template #[`item.discount`]="{ item }">
        {{ $formattedPriceYen(item.discount) }}
      </template>
      <template #[`item.billing_date`]="{ item }">
        {{ $dateHyphen(item.billing_date) }}
      </template>
      <template #[`item.interval`]="{ item }">
        <span>{{ item.interval }} {{ item.interval_category }}</span>
      </template>
      <template #[`item.is_auto_update`]="{ item }">
        <span v-if="item.is_auto_update" class="text-center"
          ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
        >
      </template>
      <template #[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDetail" x-small color="primary" @click="detail(item)"
          >detail</v-btn
        >
      </template>
    </v-data-table>
    <dealing-update-dialog
      :is-open="isOpenEditDialog"
      :dealing="dealing"
      @close="closeEditDialog"
    ></dealing-update-dialog>
    <dealing-detail-dialog
      :is-open="isOpenDetailDialog"
      :dealing="dealing"
      @close="closeDetailDialog"
    ></dealing-detail-dialog>
  </div>
</template>

<script>
import { mapActions, mapMutations, mapGetters } from 'vuex'

export default {
  name: 'DealingListTable',
  props: {
    dealings: {
      default() {
        return []
      },
      type: Array,
    },
  },
  data() {
    return {
      search: '',
      isOpenEditDialog: false,
      isOpenDetailDialog: false,
      dealing: {
        domain: [],
      },
      headers: [
        {
          text: 'Domain Name',
          value: 'domain.name',
        },
        {
          text: 'Client Name',
          value: 'client.name',
        },
        {
          text: 'Subtotal',
          value: 'subtotal',
        },
        {
          text: 'Discount',
          value: 'discount',
        },
        {
          text: 'First Billing Date',
          value: 'billing_date',
        },
        {
          text: 'Interval',
          value: 'interval',
        },
        {
          text: 'Auto Update',
          value: 'is_auto_update',
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
    ...mapGetters('dealing', ['canUpdate', 'canDetail']),
  },
  methods: {
    ...mapMutations('dealing', { dealingCommit: 'dealing' }),
    ...mapActions('dealing', ['fetchDealing']),
    openEditDialog() {
      this.isOpenEditDialog = true
    },
    closeEditDialog() {
      this.isOpenEditDialog = false
    },
    openDetailDialog() {
      this.isOpenDetailDialog = true
    },
    closeDetailDialog() {
      this.isOpenDetailDialog = false
    },
    edit(dealing) {
      this.dealing = Object.assign({}, dealing)
      this.dealing.billing_date = this.$dateHyphen(this.dealing.billing_date)
      this.openEditDialog()
    },
    detail(dealing) {
      this.dealingCommit(dealing)
      this.openDetailDialog()
    },
  },
}
</script>
