<template>
  <div class="mx-5">
    <v-form>
      <v-container>
        <v-row v-for="setting in settings" :key="setting.id">
          <v-checkbox
            v-model="setting.enabled"
            :label="setting.annotation"
            :error-messages="errors[setting.name + '.enabled']"
          ></v-checkbox>
        </v-row>
        <v-row>
          <v-col cols="12" class="pa-0 mt-10">
            <v-btn color="primary" small @click="update">Save</v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-form>
  </div>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from 'vuex'

export default {
  name: 'GeneralSetting',
  data() {
    return {
      errors: {},
    }
  },
  computed: {
    ...mapGetters('setting', ['generalSettings']),
    settings: {
      get() {
        return JSON.parse(JSON.stringify(this.generalSettings))
      },
      set() {
        this.settingCommit(this.settings)
      },
    },
  },
  methods: {
    ...mapMutations('setting', { settingCommit: 'generalSettings' }),
    ...mapActions('setting', ['updateGeneralSetting', 'sendMessage']),
    async update() {
      try {
        await this.updateGeneralSetting(this.settings)

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
