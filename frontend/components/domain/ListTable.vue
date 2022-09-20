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
          placeholder="Domain Name"
        ></v-text-field>
      </v-col>
    </v-row>
    <div class="my-2"></div>
    <v-data-table :items="domains" :headers="headers" :search="search">
      <template #[`item.is_active`]="{ item }">
        <span v-if="item.is_active" class="text-center"
          ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
        >
      </template>
      <template #[`item.is_fetching_dns`]="{ item }">
        <span v-if="item.is_fetching_dns" class="text-center"
          ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
        >
      </template>
      <template #[`item.price`]="{ item }"
        >{{ $formattedPriceYen(item.price) }}
      </template>
      <template #[`item.purchased_at`]="{ item }"
        >{{ $dateHyphen(item.purchased_at) }}
      </template>
      <template #[`item.expired_at`]="{ item }"
        >{{ $dateHyphen(item.expired_at) }}
      </template>
      <template #[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>
    <domain-update-dialog
      :is-open="isOpenEditDialog"
      :domain="domain"
      @close="closeEditDialog"
    ></domain-update-dialog>
    <domain-delete-dialog
      :is-open="isOpenDeleteDialog"
      :domain="domain"
      @close="closeDeleteDialog"
    ></domain-delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'DomainListTable',
  props: {
    domains: {
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
      isOpenDeleteDialog: false,
      domain: {},
      headers: [
        {
          text: 'Name',
          value: 'name',
        },
        {
          text: 'Price',
          value: 'price',
          filterable: false,
        },
        {
          text: 'Active',
          value: 'is_active',
          filterable: false,
        },
        {
          text: 'DNS Auto',
          value: 'is_fetching_dns',
          filterable: false,
        },
        {
          text: 'Purchased Date',
          value: 'purchased_at',
          filterable: false,
        },
        {
          text: 'Expired Date',
          value: 'expired_at',
          filterable: false,
        },
        {
          text: 'Action',
          value: 'action',
          filterable: false,
          sortable: false,
        },
      ],
    }
  },
  computed: {
    ...mapGetters('domain', ['canUpdate', 'canDelete']),
  },
  methods: {
    openEditDialog() {
      this.isOpenEditDialog = true
    },
    closeEditDialog() {
      this.isOpenEditDialog = false
    },
    openDeleteDialog() {
      this.isOpenDeleteDialog = true
    },
    closeDeleteDialog() {
      this.isOpenDeleteDialog = false
    },
    edit(domain) {
      this.domain = Object.assign({}, domain)
      this.domain.purchased_at = this.$dateHyphen(this.domain.purchased_at)
      this.domain.expired_at = this.$dateHyphen(this.domain.expired_at)
      this.domain.canceled_at = this.$dateHyphen(this.domain.canceled_at)
      this.openEditDialog()
    },
    deletion(domain) {
      this.domain = Object.assign({}, domain)
      this.openDeleteDialog()
    },
  },
}
</script>
