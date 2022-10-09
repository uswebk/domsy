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
      <template #[`item.next_billing.billing_date`]="{ item }">
        {{ $dateHyphen(item.next_billing.billing_date) }}
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
        <v-btn
          v-if="canUpdate && !item.is_halt"
          x-small
          color="primary"
          @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDetail" x-small color="primary" @click="detail(item)"
          >detail</v-btn
        >
        <v-btn
          v-if="canDelete && !item.has_fixed_billing"
          x-small
          @click="deletion(item)"
          >delete</v-btn
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
    <dealing-delete-dialog
      :is-open="isOpenDeleteDialog"
      :dealing="dealing"
      @close="closeDeleteDialog"
    ></dealing-delete-dialog>
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
      isOpenDeleteDialog: false,
      dealing: {
        domain: [],
        client: [],
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
          text: 'Next Billing Date',
          value: 'next_billing.billing_date',
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
    ...mapGetters('dealing', ['canUpdate', 'canDelete', 'canDetail']),
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
    openDeleteDialog() {
      this.isOpenDeleteDialog = true
    },
    closeDeleteDialog() {
      this.isOpenDeleteDialog = false
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
    deletion(dealing) {
      this.dealing = Object.assign({}, dealing)
      this.dealing.billing_date = this.$dateHyphen(this.dealing.billing_date)
      this.openDeleteDialog()
    },
  },
}
</script>
