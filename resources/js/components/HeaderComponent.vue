<template>
  <div>
    <v-app-bar dense app>
      <v-app-bar-nav-icon v-on:click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Domsy</v-toolbar-title>
      <v-spacer />
      <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" absolute temporary>
      <v-list>
        <v-list-item-group>
          <v-list-item><a href="#">Menu Item1</a></v-list-item>
          <v-list-item><a href="#">Menu Item2</a></v-list-item>
          <v-list-item><a href="#">Menu Item3</a></v-list-item>
          <v-list-item><a href="#">Menu Item4</a></v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  data: () => ({
        drawer: false,
    }),
}
</script>
