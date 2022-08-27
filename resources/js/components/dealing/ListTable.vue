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
      <template v-slot:[`item.subtotal`]="{ item }">
        {{ $appHelper.formattedPriceYen(item.subtotal) }}
      </template>
      <template v-slot:[`item.discount`]="{ item }">
        {{ $appHelper.formattedPriceYen(item.discount) }}
      </template>
      <template v-slot:[`item.billing_date`]="{ item }">
        {{ $dateHelper.dateHyphen(item.billing_date) }}
      </template>
      <template v-slot:[`item.interval`]="{ item }">
        <span>{{ item.interval }} {{ item.interval_category }}</span>
      </template>
      <template v-slot:[`item.is_auto_update`]="{ item }">
        <span v-if="item.is_auto_update" class="text-center"
          ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
        >
      </template>
      <template v-slot:[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDetail" x-small color="primary" @click="detail(item)"
          >detail</v-btn
        >
      </template>
    </v-data-table>

    <update-dialog
      :isOpen="isOpenEditDialog"
      :dealing="dealing"
      @close="closeEditDialog"
    ></update-dialog>

    <detail-dialog
      :isOpen="isOpenDetailDialog"
      :dealing="dealing"
      @close="closeDetailDialog"
    ></detail-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import UpdateDialog from '../../components/dealing/UpdateDialog'
import DetailDialog from '../../components/dealing/DetailDialog'

export default {
  name: 'DealingListTable',

  components: {
    UpdateDialog,
    DetailDialog,
  },

  props: {
    dealings: {
      default() {
        return []
      },
      type: Array,
    },
  },

  computed: {
    ...mapGetters('dealing', ['canUpdate', 'canDetail']),
  },

  data() {
    return {
      search: '',
      isOpenEditDialog: false,
      isOpenDetailDialog: false,
      dealing: {},
      headers: [
        {
          text: 'Domain Name',
          value: 'domain',
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

  methods: {
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
      this.dealing = dealing
      this.dealing.billing_date = this.$dateHelper.dateHyphen(
        dealing.billing_date
      )

      this.openEditDialog()
    },

    detail(dealing) {
      this.$emit('detail', dealing)
    },
  },
}
</script>
