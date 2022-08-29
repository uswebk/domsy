<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-cog'"
        :headlineText="'Settings'"
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

      <v-container>
        <v-tabs v-model="tab">
          <v-tab href="#mail">Mail</v-tab>
          <v-tab href="#general">General</v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
          <v-tab-item value="mail">
            <mail-setting></mail-setting>
          </v-tab-item>
          <v-tab-item value="general">
            <general-setting></general-setting>
          </v-tab-item>
        </v-tabs-items>
      </v-container>
    </v-container>
  </v-main>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import MailSetting from '../../components/setting/MailSetting'
import GeneralSetting from '../../components/setting/GeneralSetting'

export default {
  name: 'SettingPage',
  components: {
    IconHeadLine,
    GreetingMessage,
    MailSetting,
    GeneralSetting,
  },
  data() {
    return {
      tab: '',
    }
  },
  computed: {
    ...mapGetters('setting', ['pageLoading', 'greetingType', 'greeting']),
  },
  methods: {
    ...mapActions('setting', ['fetchMailSettings', 'fetchGeneralSettings']),
  },
  created() {
    this.fetchMailSettings()
    this.fetchGeneralSettings()
  },
}
</script>
