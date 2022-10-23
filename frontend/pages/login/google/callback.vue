<template>
  <v-container style="padding: 0" fill-height fluid> hoge </v-container>
</template>

<script>
// import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'GoogleCallbackPage',
  authenticated: false,
  computed: {},
  async mounted() {
    const response = await this.$axios.get('api/login/google/callback', {
      params: this.$route.query,
    })

    console.log(response)
    location.href = '/mypage'
  },
  methods: {},
}
</script>
