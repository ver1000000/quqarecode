<template>
  <v-app>
    <!-- <v-app-bar app>
      <v-toolbar-title>🐓 Кукарекод генератор</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn to="/about" text>О проекте</v-btn>
    </v-app-bar> -->
    <v-main class="d-flex align-center justify-center">
      <router-view></router-view>
    </v-main>
    <v-footer class="justify-center">
      <router-link to="/" class="text-decoration-none mr-6">Сгенерировать код</router-link>
      <router-link to="/about" class="text-decoration-none">О проекте</router-link>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: 'App'
}
</script>
