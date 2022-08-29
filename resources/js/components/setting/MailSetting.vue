<template>
  <div>
    <v-form>
      <v-container>
        <v-row v-for="mailSetting in mailSettings" :key="mailSetting.id">
          <v-checkbox
            v-model="mailSetting.is_received"
            :label="mailSetting.annotation"
            hide-details
          ></v-checkbox>
          <span v-if="errors[mailSetting.name + '.is_received']">
            <validation-error-message
              :message="errors[mailSetting.name + '.is_received']"
            ></validation-error-message>
          </span>

          <span v-if="mailSetting.has_days" class="ml-5">
            <span width="100px">
              <v-text-field
                v-model="mailSetting.notice_number_days"
                type="number"
                min="0"
                class="notice_number_days_text_field"
                suffix="Days ago"
                hide-details
              ></v-text-field>
              <span v-if="errors[mailSetting.name + '.notice_number_days']">
                <validation-error-message
                  :message="errors[mailSetting.name + '.notice_number_days']"
                ></validation-error-message>
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
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import ValidationErrorMessage from '../../components/form/ValidationErrorMessage'

export default {
  name: 'MailSetting',
  components: {
    ValidationErrorMessage,
  },

  data() {
    return {
      errors: {},
    }
  },
  computed: {
    ...mapGetters('setting', ['mailSettings']),
  },
  methods: {
    ...mapActions('setting', ['updateMailSetting', 'sendMessage']),
    async updateMail() {
      try {
        await this.updateMailSetting(this.mailSettings)

        this.sendMessage({
          greeting: 'Setting Update Success',
          greetingType: 'success',
        })
      } catch (error) {
        const status = error.response.status
        let message = ''

        if (status === 422) {
          var responseErrors = error.response.data.errors

          for (var key in responseErrors) {
            this.errors[key] = responseErrors[key][0]
          }
          return
        }
        if (status === 403) {
          message = 'Illegal operation was performed.'
        }
        if (status >= 500) {
          message = 'Server Error'
        }

        this.sendMessage({
          greeting: message,
          greetingType: 'error',
        })
      }
    },
  },
}
</script>
<style scoped>
.notice_number_days_text_field {
  width: 130px;
}
</style>
