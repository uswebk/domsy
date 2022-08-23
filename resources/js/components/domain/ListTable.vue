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
        >{{ formattedPrice(item.price) }}
      </template>
      <template v-slot:[`item.purchased_at`]="{ item }"
        >{{ formattedDate(item.purchased_at) }}
      </template>
      <template v-slot:[`item.expired_at`]="{ item }"
        >{{ formattedDate(item.expired_at) }}
      </template>
      <template v-slot:[`item.canceled_at`]="{ item }"
        >{{ formattedDate(item.canceled_at) }}
      </template>
      <template v-slot:[`item.action`]="{ item }">
        <v-btn v-if="canUpdate" x-small color="primary" @click="edit(item)"
          >edit</v-btn
        >
        <v-btn v-if="canDelete" x-small @click="deleteDomain(item)"
          >delete</v-btn
        >
      </template>
    </v-data-table>

    <update-dialog :domain="domain"></update-dialog>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
import { shortHyphenDate } from '../../modules/DateHelper'
import { priceFormat } from '../../modules/AppHelper'
import UpdateDialog from '../../components/domain/UpdateDialog'

export default {
  components: {
    UpdateDialog,
  },

  name: 'ListTable',
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
      domain: {},
    }
  },

  computed: {
    ...mapGetters('domain', ['domainHeaders', 'canUpdate', 'canDelete']),
    headers() {
      return this.domainHeaders
    },
  },

  methods: {
    ...mapMutations('domain', {
      isOpenEditDialog: 'isOpenEditDialog',
    }),

    edit(domain) {
      this.domain.id = domain.id
      this.domain.name = domain.name
      this.domain.price = domain.price
      this.domain.registrar_id = domain.registrar_id
      this.domain.is_active = domain.is_active
      this.domain.is_transferred = domain.is_transferred
      this.domain.is_management_only = domain.is_management_only
      this.domain.purchased_at = this.formattedDate(domain.purchased_at)
      this.domain.expired_at = this.formattedDate(domain.expired_at)
      this.domain.canceled_at = this.formattedDate(domain.canceled_at)

      this.isOpenEditDialog(true)
    },

    deleteDomain(domain) {
      this.$emit('delete', domain)
    },

    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },

    formattedPrice(price) {
      return priceFormat(price)
    },
  },
}
</script>
