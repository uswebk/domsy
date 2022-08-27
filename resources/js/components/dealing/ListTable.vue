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

    <!-- <div v-for="(dealing, index) in dealings" :key="dealing.id">
      {{ dealing.domain_dealings }}
    </div>
 -->
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
  </div>
</template>

<script>
export default {
  name: 'ListTable',
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
      canUpdate: false,
      canDetail: false,

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
    // async roleCheck() {
    //   let canUpdateResult = await axios.get(
    //     '/api/roles/user/?has=api.dealings.update'
    //   )
    //   this.canUpdate = canUpdateResult.data

    //   let canDetailResult = await axios.get(
    //     '/api/roles/user/?has=api.dealings.detail'
    //   )
    //   this.canDetail = canDetailResult.data
    // },

    edit(dealing) {
      this.$emit('edit', dealing)
    },

    detail(dealing) {
      this.$emit('detail', dealing)
    },
  },
}
</script>
