<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-cog</v-icon> Settings
      </h1>

      <div class="py-5"></div>
      <v-alert dense text dismissible type="success" v-if="greeting">{{
        greeting
      }}</v-alert>
      <v-alert dense text dismissible type="error" v-if="alert">{{
        alert
      }}</v-alert>

      <v-container>
        <p class="text-h6 ma-0">Mail</p>
        <v-divider></v-divider>

        <v-form>
          <v-container>
            <v-row
              v-for="userMailSetting in userMailSettings"
              :key="userMailSetting.id"
            >
              <v-checkbox
                v-model="userMailSetting.is_received"
                :label="userMailSetting.annotation"
                hide-details
              ></v-checkbox>
              <span v-if="updateErrors[userMailSetting.name + '.is_received']">
                <ValidationErrorMessage
                  :message="updateErrors[userMailSetting.name + '.is_received']"
                />
              </span>

              <span v-if="userMailSetting.has_days" class="ml-5">
                <span width="100px">
                  <v-text-field
                    v-model="userMailSetting.notice_number_days"
                    type="number"
                    min="0"
                    class="notice_number_days_text_field"
                    suffix="Days ago"
                    hide-details
                  ></v-text-field>
                  <span
                    v-if="
                      updateErrors[userMailSetting.name + '.notice_number_days']
                    "
                  >
                    <ValidationErrorMessage
                      :message="
                        updateErrors[
                          userMailSetting.name + '.notice_number_days'
                        ]
                      "
                    />
                  </span>
                </span>
              </span>
            </v-row>

            <v-row>
              <v-col cols="12" class="pa-0 mt-10">
                <v-btn color="primary" small @click="updateMail">Save</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-form>

        <div class="py-5"></div>

        <p class="text-h6 ma-0">Batch</p>
        <v-divider></v-divider>
        <v-form>
          <v-container>
            <v-row
              v-for="generalSetting in generalSettings"
              :key="generalSetting.id"
            >
              <v-checkbox
                v-model="generalSetting.enabled"
                :label="generalSetting.annotation"
                hide-details
              ></v-checkbox>
            </v-row>

            <v-row>
              <v-col cols="12" class="pa-0 mt-10">
                <v-btn color="primary" small @click="updateGeneral">Save</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-form>
      </v-container>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
import ValidationErrorMessage from '../../components/form/ValidationErrorMessage'

export default {
  components: {
    ValidationErrorMessage,
  },

  data() {
    return {
      greeting: '',
      alert: '',

      userMailSettings: {},
      generalSettings: {},
      updateErrors: {},
    }
  },

  methods: {
    async initSettings() {
      const result = await axios.get('/api/settings/user-mails')

      let userMailSettings = {}
      for (let key in result.data) {
        userMailSettings[result.data[key].name] = result.data[key]
      }

      this.userMailSettings = userMailSettings
    },

    async initGenerals() {
      const result = await axios.get('/api/settings/user-generals')

      let generalSettings = {}
      for (let key in result.data) {
        generalSettings[result.data[key].name] = result.data[key]
      }

      this.generalSettings = generalSettings
    },

    async updateMail() {
      try {
        const result = await axios.put(
          '/api/settings/user-mails',
          this.userMailSettings
        )
        if (result.status === 200) {
          this.greeting = 'Update success'
        }

        this.initSettings()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeEditModal()
        }

        if (status === 422) {
          var responseErrors = error.response.data.errors

          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.updateErrors = errors
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeEditModal()
        }
      }
    },

    async updateGeneral() {
      try {
        const result = await axios.put(
          '/api/settings/user-generals',
          this.generalSettings
        )
        if (result.status === 200) {
          this.greeting = 'Update success'
        }

        this.initGenerals()
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeEditModal()
        }

        if (status === 422) {
          var responseErrors = error.response.data.errors

          var errors = {}
          for (var key in responseErrors) {
            errors[key] = responseErrors[key][0]
          }
          this.updateErrors = errors
        }

        if (status >= 500) {
          this.alert = 'Server Error'
          this.closeEditModal()
        }
      }
    },
  },

  created() {
    this.initSettings()
    this.initGenerals()
  },
}
</script>
<style scoped>
.notice_number_days_text_field {
  width: 130px;
}
</style>
