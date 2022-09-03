<template>
  <div class="mx-5">
    <v-form>
      <v-container>
        <v-row v-for="setting in settings" :key="setting.id">
          <v-checkbox
            v-model="setting.is_received"
            :label="setting.annotation"
            :error-messages="errors[setting.name + '.is_received']"
          ></v-checkbox>
          <span v-if="setting.has_days" class="ml-5">
            <span width="100px">
              <v-text-field
                v-model="setting.notice_number_days"
                type="number"
                min="0"
                class="notice-number-days-text-field"
                suffix="Days ago"
                :error-messages="errors[setting.name + '.notice_number_days']"
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
import { mapGetters, mapMutations, mapActions } from 'vuex'

export default {
  name: 'MailSetting',
  data() {
    return {
      errors: {},
    }
  },
  computed: {
    ...mapGetters('setting', ['mailSettings']),
    settings: {
      get() {
        return JSON.parse(JSON.stringify(this.mailSettings))
      },
      set() {
        this.settingCommit(this.settings)
      },
    },
  },
  methods: {
    ...mapMutations('setting', { settingCommit: 'generalSettings' }),
    ...mapActions('setting', ['updateMailSetting', 'sendMessage']),
    async updateMail() {
      try {
        await this.updateMailSetting(this.settings)

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
          for (const key in errors) {
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
.notice-number-days-text-field {
  width: 130px;
}
</style>
