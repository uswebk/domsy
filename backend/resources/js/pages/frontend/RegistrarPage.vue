<template>
  <base-frame>
    <template v-slot:main>
      <v-main>
        <v-container>
          <icon-head-line
            :icon="'mdi-domain'"
            :headlineText="'Registrar'"
          ></icon-head-line>
          <div class="py-5"></div>
          <greeting-message
            :type="greetingType"
            :message="greeting"
          ></greeting-message>
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
          <list-table :registrars="registrars"></list-table>
          <new-dialog
            :isOpen="isOpenNewDialog"
            @close="closeNewDialog"
          ></new-dialog>
        </v-container>
      </v-main>
    </template>
  </base-frame>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import BaseFrame from '../../components/common/BaseFrame'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import ListTable from '../../components/registrar/ListTable'
import NewDialog from '../../components/registrar/NewDialog'

export default {
  name: 'RegistrarPage',
  components: {
    BaseFrame,
    IconHeadLine,
    GreetingMessage,
    NewDialog,
    ListTable,
  },
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
  methods: {
    ...mapActions('registrar', ['fetchRegistrars', 'initRole']),

    openNewDialog() {
      this.isOpenNewDialog = true
    },

    closeNewDialog() {
      this.isOpenNewDialog = false
    },
  },
  async created() {
    this.fetchRegistrars()
    this.initRole()
  },
}
</script>
