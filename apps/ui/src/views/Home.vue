<template>
  <v-app>
    <v-app-bar app>
      <v-toolbar-title>My App</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn to="/about" text>About</v-btn>
    </v-app-bar>

    <v-main>
      <v-container>
        <v-form @submit.prevent="submitForm">
          <v-text-field label="Name" v-model="name"></v-text-field>
          <v-btn type="submit" color="primary">Submit</v-btn>
        </v-form>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { ref } from 'vue';

export default {
  setup() {
    const name = ref('');
    const socket = new WebSocket('ws://localhost:8080');

    socket.onopen = () => {
      console.log('WebSocket connection established');
    };

    const submitForm = () => {
      console.log('Form submitted:', name.value);
      const event = {
        id: Date.now(),
        name: 'form_submission',
        props: JSON.stringify({ name: name.value }),
      };
      socket.send(JSON.stringify(event));
    };

    return {
      name,
      submitForm,
    };
  },
};
</script> 