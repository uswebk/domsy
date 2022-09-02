<template>
  <div class="mx-5">
    <v-form>
      <v-container>
        <v-row
          v-for="generalSetting in generalSettings"
          :key="generalSetting.id"
        >
          <v-checkbox
            v-model="generalSetting.enabled"
            :label="generalSetting.annotation"
            :error-messages="errors[generalSetting.name + '.enabled']"
          ></v-checkbox>
        </v-row>
        <v-row>
          <v-col cols="12" class="pa-0 mt-10">
            <v-btn color="primary" small @click="updateGeneral">Save</v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'GeneralSetting',
  data() {
    return {
      errors: {},
    }
  },
  computed: {
    ...mapGetters('setting', ['generalSettings']),
  },
  methods: {
    ...mapActions('setting', ['updateGeneralSetting', 'sendMessage']),

    async updateGeneral() {
      try {
        await this.updateGeneralSetting(this.generalSettings)

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
