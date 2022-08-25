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
    <v-data-table :items="domains" :headers="headers" :search="search">
      <template v-slot:[`item.is_active`]="{ item }">
        <span v-if="item.is_active" class="text-center"
          ><v-icon small>mdi-checkbox-marked-circle</v-icon></span
        >
      </template>
      <template v-slot:[`item.price`]="{ item }"
        >{{ $appHelper.formattedPriceYen(item.price) }}
      </template>
      <template v-slot:[`item.purchased_at`]="{ item }"
        >{{ $dateHelper.dateHyphen(item.purchased_at) }}
      </template>
      <template v-slot:[`item.expired_at`]="{ item }"
        >{{ $dateHelper.dateHyphen(item.expired_at) }}
      </template>
      <template v-slot:[`item.canceled_at`]="{ item }"
        >{{ $dateHelper.dateHyphen(item.canceled_at) }}
      </template>
      <template v-slot:[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deletion(item)">delete</v-btn>
      </template>
    </v-data-table>

    <update-dialog
      :isOpen="isOpenEditDialog"
      :domain="domain"
      @close="closeEditDialog"
    ></update-dialog>

    <delete-dialog
      :isOpen="isOpenDeleteDialog"
      :domain="domain"
      @close="closeDeleteDialog"
    ></delete-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import UpdateDialog from '../../components/domain/UpdateDialog'
import DeleteDialog from '../../components/domain/DeleteDialog'

export default {
  name: 'DomainListTable',

  components: {
    UpdateDialog,
    DeleteDialog,
  },

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
        },
        {
          text: 'Active',
          value: 'is_active',
        },
        {
          text: 'Purchased Date',
          value: 'purchased_at',
        },
        {
          text: 'Expired Date',
          value: 'expired_at',
        },
        {
          text: 'Canceled Date',
          value: 'canceled_at',
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
      this.domain.id = domain.id
      this.domain.name = domain.name
      this.domain.price = domain.price
      this.domain.registrar_id = domain.registrar_id
      this.domain.is_active = domain.is_active
      this.domain.is_transferred = domain.is_transferred
      this.domain.is_management_only = domain.is_management_only
      this.domain.purchased_at = this.$dateHelper.dateHyphen(
        domain.purchased_at
      )
      this.domain.expired_at = this.$dateHelper.dateHyphen(domain.expired_at)
      this.domain.canceled_at = this.$dateHelper.dateHyphen(domain.canceled_at)

      this.openEditDialog()
    },

    deletion(domain) {
      this.domain = domain

      this.openDeleteDialog()
    },
  },
}
</script>
