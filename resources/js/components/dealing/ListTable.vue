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

    <v-data-table
      :headers="headers"
      :items="dealings"
      :search="search"
      :loading="loading"
    >
      <template v-slot:[`item.interval`]="{ item }">
        <span>{{ item.interval }} {{ item.interval_category }}</span>
      </template>
      <template v-slot:[`item.subtotal`]="{ item }">
        {{ formattedPrice(item.subtotal) }}
      </template>
      <template v-slot:[`item.discount`]="{ item }">
        {{ formattedPrice(item.discount) }}
      </template>
      <template v-slot:[`item.billing_date`]="{ item }">
        {{ formattedDate(item.billing_date) }}
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
  </div>
</template>

<script>
import axios from 'axios'
import { shortHyphenDate } from '../../modules/DateHelper'
import { priceFormat } from '../../modules/AppHelper'

export default {
  name: 'ListTable',
  props: {
    headers: {
      default: null,
      type: Array,
      required: true,
    },
    dealings: {
      default() {
        return []
      },
      type: Array,
    },
  },

  data() {
    return {
      loading: true,
      search: '',
      canUpdate: false,
      canDetail: false,
    }
  },

  methods: {
    async roleCheck() {
      let canUpdateResult = await axios.get(
        '/api/roles/user/?has=api.dealings.update'
      )
      this.canUpdate = canUpdateResult.data

      let canDetailResult = await axios.get(
        '/api/roles/user/?has=api.dealings.detail'
      )
      this.canDetail = canDetailResult.data
    },

    edit(dealing) {
      this.$emit('edit', dealing)
    },

    detail(dealing) {
      this.$emit('detail', dealing)
    },
    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },

    formattedPrice(price) {
      return priceFormat(price)
    },
  },

  async created() {
    this.loading = true

    await this.roleCheck()

    this.loading = false
  },
}
</script>
