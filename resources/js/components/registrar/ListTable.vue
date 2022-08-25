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
    <v-data-table :headers="headers" :items="registrars" :search="search">
      <template v-slot:[`item.link`]="{ item }">
        <a :href="item.link" target="_blank">{{ item.link }}</a>
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

export default {
  name: 'RegistrarListTable',
  props: {
    registrars: {
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
      headers: [
        {
          text: 'Name',
          value: 'name',
        },
        {
          text: 'Link',
          value: 'link',
        },
        {
          text: 'Note',
          value: 'note',
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
    ...mapGetters('registrar', ['canUpdate', 'canDelete']),
  },

  methods: {
    edit(registrar) {
      this.$emit('edit', registrar)
    },

    deleteRegistrar(registrar) {
      this.$emit('delete', registrar)
    },
  },
}
</script>
