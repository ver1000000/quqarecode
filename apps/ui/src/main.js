import { createApp } from 'vue'
import { createVuetify } from 'vuetify'
import App from './App.vue'
import router from './router'
import eventTracker from './plugins/eventTracker'

// Vuetify
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
  },
})

const app = createApp(App)

// Use plugins
app.use(router)
app.use(vuetify)
app.use(eventTracker)

// Provide the $eventTracker globally
app.provide('$eventTracker', app.config.globalProperties.$eventTracker)

// Mount the app
app.mount('#app')
