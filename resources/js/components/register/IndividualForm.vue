<template>
  <v-tab-item value="individual">
    <v-form ref="form" class="pa-4">
      <v-text-field
        class="mb-5"
        v-model="name"
        label="Name"
        required
        hide-details
      ></v-text-field>
      <ValidationErrorMessage :message="errors.name" />
      <v-text-field
        class="mb-5"
        v-model="email"
        label="Email"
        required
        hide-details
      ></v-text-field>
      <ValidationErrorMessage :message="errors.email" />
      <v-text-field
        v-model="password"
        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
        :type="showPassword ? 'text' : 'password'"
        name="password"
        label="Password"
        hint="At least 8 characters"
        counter
        @click:append="showPassword = !showPassword"
      ></v-text-field>
      <ValidationErrorMessage :message="errors.password" />
      <v-text-field
        v-model="passwordConfirmation"
        type="password"
        name="password_confirmation"
        label="Confirm Password"
        counter
        required
      ></v-text-field>
      <ValidationErrorMessage :message="errors.password_confirmation" />
      <div class="my-5"></div>
      <v-btn class="mr-4" color="primary" @click="register"> Register </v-btn>
    </v-form>
  </v-tab-item>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
    },
  },
}
</script>
