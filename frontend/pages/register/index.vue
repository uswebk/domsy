<template>
  <v-app>
    <v-container style="padding: 0" fill-height fluid>
      <v-progress-linear
        v-show="pageLoading"
        indeterminate
        color="yellow darken-2"
      ></v-progress-linear>
      <v-row style="height: 100%; padding: 0">
        <v-col
          cols="5"
          class="d-flex align-center"
          style="background-color: #e8c46a; position: relative"
        >
          <v-img src="/images/domsy.jpg"></v-img>
          <v-fab-transition>
            <v-btn
              fab
              bottom
              right
              absolute
              style="bottom: 50px"
              elevation="1"
              href="https://github.com/uswebk/domsy"
              small
            >
              <v-icon>mdi-github</v-icon>
            </v-btn>
          </v-fab-transition>
        </v-col>
        <v-col cols="7" justify="center" align-self="center">
          <v-row>
            <v-col align="center" cols="12"
              ><p class="ma-0 text-h4">
                <nuxt-link to="/" style="text-decoration: none"
                  ><span class="blue-grey--text font-weight-black">
                    Select Registration Method</span
                  >
                </nuxt-link>
              </p>
            </v-col>
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
                      <p class="subheading mt-2 text-xs-center">
                        Corporation →
                      </p>
                    </v-layout>
                  </v-card-text>
                </v-card>
              </v-layout>
            </v-col>
            <v-col align="center" cols="12">
              <v-btn color="gray" to="/" nuxt x-small class="py-4 mb-2">
                <v-icon>mdi-chevron-left</v-icon>
              </v-btn>
            </v-col>
          </v-row>
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
