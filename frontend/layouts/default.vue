<template>
  <v-app>
    <nuxt />
  </v-app>
</template>

<script>
export default {
  name: 'DefaultLayout',
  data() {
    return {}
  },
  mounted() {
    // ユーザーを取得してきてメール認証がまだならメール認証ページにリダイレクト
    console.log('ok')
  },
}
</script>
