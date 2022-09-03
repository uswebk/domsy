<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-cog'"
            :headline-text="'Settings'"
          ></common-icon-head-line>
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
          <v-container>
            <v-tabs v-model="tab">
              <v-tab href="#mail">Mail</v-tab>
              <v-tab href="#general">General</v-tab>
            </v-tabs>
            <v-tabs-items v-model="tab">
              <v-tab-item value="mail">
                <setting-mail-setting></setting-mail-setting>
              </v-tab-item>
              <v-tab-item value="general">
                <setting-general-setting></setting-general-setting>
              </v-tab-item>
            </v-tabs-items>
          </v-container>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'SettingPage',
  data() {
    return {
      tab: '',
    }
  },
  computed: {
    ...mapGetters('setting', ['pageLoading', 'greetingType', 'greeting']),
  },
  created() {
    this.fetchMailSettings()
    this.fetchGeneralSettings()
  },
  methods: {
    ...mapActions('setting', ['fetchMailSettings', 'fetchGeneralSettings']),
  },
}
</script>
