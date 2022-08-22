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
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { shortHyphenDate } from '../../modules/DateHelper'
import { priceFormat } from '../../modules/AppHelper'

export default {
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
    }
  },

  computed: {
    ...mapGetters('domain', ['domainHeaders', 'canUpdate', 'canDelete']),
    headers() {
      return this.domainHeaders
    },
  },

  methods: {
    edit(domain) {
      this.$emit('edit', domain)
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
