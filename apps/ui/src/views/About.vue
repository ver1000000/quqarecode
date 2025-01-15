<template>
  <v-app>
    <v-app-bar app>
      <v-toolbar-title>My App</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn to="/" text>Home</v-btn>
    </v-app-bar>

    <v-main>
      <v-container>
        <h1>About Page</h1>
        <p>This is the about page of the application.</p>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'About',
};
</script> 