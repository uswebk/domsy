<template>
  <v-app>
    <v-container class="pa-4" fill-height fluid>
      <v-row justify="center">
        <v-col align="center" cols="1"
          ><p class="ma-0 text-h4">
            <nuxt-link to="/" style="text-decoration: none"
              ><span class="blue-grey--text font-weight-black">Domsy.</span>
            </nuxt-link>
          </p></v-col
        >
        <v-col cols="12">
          <v-layout justify-center align-center wrap bottom>
            <v-card
              class="px-2 ma-2"
              style="min-width: 200px"
              href="/register/individual"
            >
              <v-card-text>
                <v-layout justify-center column align-center>
                  <v-flex class="mt-5">
                    <v-avatar size="60" color="indigo">
                      <v-icon dark>mdi-account-box</v-icon>
                    </v-avatar>
                  </v-flex>
                  <p class="subheading mt-2 text-xs-center">Individual →</p>
                </v-layout>
              </v-card-text>
            </v-card>
            <v-card
              class="px-2 ma-2"
              style="min-width: 200px"
              href="/register/corporation"
            >
              <v-card-text>
                <v-layout justify-center column align-center>
                  <v-flex class="mt-5">
                    <v-avatar size="60" color="teal">
                      <v-icon dark>mdi-domain</v-icon>
                    </v-avatar>
                  </v-flex>
                  <p class="subheading mt-2 text-xs-center">Corporation →</p>
                </v-layout>
              </v-card-text>
            </v-card>
          </v-layout>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
export default {
  name: 'RegisterIndexPage',
}
</script>
