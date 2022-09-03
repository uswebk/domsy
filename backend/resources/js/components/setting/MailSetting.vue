<template>
  <div class="mx-5">
    <v-form>
      <v-container>
        <v-row v-for="mailSetting in mailSettings" :key="mailSetting.id">
          <v-checkbox
            v-model="mailSetting.is_received"
            :label="mailSetting.annotation"
            :error-messages="errors[mailSetting.name + '.is_received']"
          ></v-checkbox>
          <span v-if="mailSetting.has_days" class="ml-5">
            <span width="100px">
              <v-text-field
                v-model="mailSetting.notice_number_days"
                type="number"
                min="0"
                class="notice_number_days_text_field"
                suffix="Days ago"
                :error-messages="
                  errors[mailSetting.name + '.notice_number_days']
                "
              ></v-text-field>
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

export default {
  name: 'MailSetting',
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
        let message = ''
        const status = error.response.status

        if (status === 422) {
          const errors = error.response.data.errors
          const _errors = {}
          for (let key in errors) {
            _errors[key] = errors[key][0]
          }
          this.errors = _errors
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
