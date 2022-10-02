<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-domain'"
            :headline-text="'Registrar'"
          ></common-icon-head-line>
          <common-greeting-message
            :type="greetingType"
            :message="greeting"
          ></common-greeting-message>
          <v-progress-linear
            v-show="pageLoading"
            color="yellow darken-2"
            indeterminate
            rounded
            height="6"
          ></v-progress-linear>
          <v-btn
            v-if="canStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewDialog"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>
          <registrar-list-table :registrars="registrars"></registrar-list-table>
          <registrar-new-dialog
            :is-open="isOpenNewDialog"
            @close="closeNewDialog"
          ></registrar-new-dialog>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'RegistrarPage',
  data() {
    return {
      registrar: {},
      isOpenNewDialog: false,
    }
  },
  computed: {
    ...mapGetters('registrar', [
      'registrars',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
  },
  created() {
    this.fetchRegistrars()
    this.initRole()
  },
  methods: {
    ...mapActions('registrar', ['fetchRegistrars', 'initRole']),
    openNewDialog() {
      this.isOpenNewDialog = true
    },
    closeNewDialog() {
      this.isOpenNewDialog = false
    },
  },
}
</script>
