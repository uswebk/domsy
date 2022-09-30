<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-account-box'"
            :headline-text="'Mypage'"
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
          <v-container class="pa-14">
            <mypage-profile></mypage-profile>
            <v-divider class="my-10"></v-divider>
            <mypage-menu-list></mypage-menu-list>
            <v-divider class="my-10"></v-divider>
            <mypage-account-operation></mypage-account-operation>
          </v-container>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'MyPage',
  computed: {
    ...mapGetters('menu', ['pageLoading']),
    ...mapGetters('account', ['greeting', 'greetingType']),
  },
  mounted() {
    this.initMessage()
  },
  methods: {
    ...mapActions('account', ['initMessage']),
  },
}
</script>
