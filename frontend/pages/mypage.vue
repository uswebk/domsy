<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <h1 class="text-h5 font-weight-bold">
            <v-icon large>mdi-account-box</v-icon> Mypage
          </h1>
          <div class="py-5"></div>
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
          </v-container>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'MyPage',
  computed: {
    ...mapGetters('menu', ['pageLoading']),
    ...mapGetters('account', ['greeting', 'greetingType']),
  },
}
</script>
