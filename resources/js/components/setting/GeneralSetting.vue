<template>
  <div>
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
          <validation-error-message
            :message="errors[generalSetting.name + '.enabled']"
          ></validation-error-message>
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
import ValidationErrorMessage from '../../components/form/ValidationErrorMessage'

export default {
  name: 'GeneralSetting',
  components: {
    ValidationErrorMessage,
  },
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
