<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-cog</v-icon> Settings
      </h1>

      <div class="py-5"></div>

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

              <span v-if="userMailSetting.has_days" class="ml-5">
                <span width="100px">
                  <v-text-field
                    v-model="userMailSetting.notice_number_days"
                    hide-details
                    type="number"
                    class="notice_number_days_text_field"
                    suffix="Days ago"
                  ></v-text-field>
                  <p
                    class="red--text text-sm-body-2"
                    v-text="
                      updateErrors[userMailSetting.name + '.notice_number_days']
                    "
                    v-if="
                      updateErrors[userMailSetting.name + '.notice_number_days']
                    "
                  ></p>
                </span>
              </span>
            </v-row>

            <v-row>
              <v-col cols="12" class="pa-0 mt-10">
                <v-btn color="primary" @click="updateMail">Save</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-form>

        <div class="py-5"></div>

        <p class="text-h6 ma-0">Batch</p>
        <v-divider></v-divider>
      </v-container>
    </v-container>
  </v-main>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      greeting: '',
      alert: '',

      userMailSettings: {},
      updateErrors: {},

      hoge: {
        'fuga.toya': 'testdesu',
      },

      fuga: 'fuga',
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

    async updateMail() {
      try {
        const result = await axios.put(
          '/api/settings/user-mails',
          this.userMailSettings
        )

        console.log(result)
      } catch (error) {
        const status = error.response.status

        if (status === 403) {
          this.alert = 'Illegal operation was performed.'
          this.closeEditModal()
        }

        if (status === 422) {
          var responseErrors = error.response.data.errors

          console.log(responseErrors)
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
  },
}
</script>
<style scoped>
.notice_number_days_text_field {
  width: 130px;
}
</style>
