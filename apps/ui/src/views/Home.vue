<template>
  <v-app>
    <v-app-bar app>
      <v-toolbar-title>My App</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn to="/about" text>About</v-btn>
    </v-app-bar>

    <v-main>
      <v-container>
        <v-alert
          v-if="connectionError"
          type="error"
          dismissible
          @click="initWebSocket"
        >
          {{ connectionError }}
          Click to reconnect
        </v-alert>

        <v-form @submit.prevent="submitForm">
          <v-text-field label="Name" v-model="name"></v-text-field>
          <v-btn 
            type="submit" 
            color="primary"
            :disabled="!isConnected"
          >
            Submit
          </v-btn>
        </v-form>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';

export default {
  setup() {
    const name = ref('');
    const socket = ref(null);
    const isConnected = ref(false);
    const connectionError = ref('');
    let reconnectTimeout = null;

    const initWebSocket = () => {
      if (socket.value && socket.value.readyState <= 1) {
        socket.value.close();
      }

      connectionError.value = '';
      socket.value = new WebSocket(import.meta.env.VITE_WS_URL);

      socket.value.onopen = () => {
        console.log('WebSocket connection established');
        isConnected.value = true;
        connectionError.value = '';
      };

      socket.value.onclose = () => {
        console.log('WebSocket connection closed');
        isConnected.value = false;
        // Try to reconnect after 5 seconds
        reconnectTimeout = setTimeout(initWebSocket, 5000);
      };

      socket.value.onerror = (error) => {
        console.error('WebSocket error:', error);
        connectionError.value = 'Failed to connect to server. Click to try again.';
        isConnected.value = false;
      };
    };

    const submitForm = () => {
      if (!socket.value || socket.value.readyState !== WebSocket.OPEN) {
        connectionError.value = 'Not connected to server. Please wait...';
        return;
      }

      const event = {
        id: Date.now(),
        name: 'form_submission',
        props: JSON.stringify({ name: name.value }),
      };

      try {
        socket.value.send(JSON.stringify(event));
        name.value = ''; // Clear the form after successful submission
      } catch (error) {
        console.error('Failed to send message:', error);
        connectionError.value = 'Failed to send message. Please try again.';
      }
    };

    onMounted(() => {
      initWebSocket();
    });

    onUnmounted(() => {
      if (socket.value) {
        socket.value.close();
      }
      if (reconnectTimeout) {
        clearTimeout(reconnectTimeout);
      }
    });

    return {
      name,
      isConnected,
      connectionError,
      submitForm,
      initWebSocket,
    };
  },
};
</script> 