<template>
  <v-row justify="center" class="d-flex align-center">
    <v-col cols="1">
      <v-btn small @click="openWithdrawDialog"
        ><v-icon dark left> mdi-account-cancel </v-icon> Withdraw</v-btn
      >
    </v-col>
    <mypage-withdraw-dialog
      :is-open="isWithoutDialog"
      @close="closeWithdrawDialog"
    ></mypage-withdraw-dialog>
  </v-row>
</template>

<script>
export default {
  name: 'MypageWithdraw',
  data() {
    return {
      isWithoutDialog: false,
    }
  },
  methods: {
    openWithdrawDialog() {
      this.isWithoutDialog = true
    },
    closeWithdrawDialog() {
      this.isWithoutDialog = false
    },
  },
}
</script>
