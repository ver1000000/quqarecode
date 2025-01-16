import { createApp } from 'vue'
import { createVuetify } from 'vuetify'
import App from './App.vue'
import eventTrackerPlugin from './plugins/eventTracker'
import createAppRouter from './router'
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

// Init event tracker before router
app.use(eventTrackerPlugin)

const eventTracker = app.config.globalProperties.$eventTracker
const router = createAppRouter(eventTracker);

// Use plugins
app.use(router)
app.use(vuetify)

// Provide the $eventTracker globally
app.provide('$eventTracker', eventTracker)

// Mount the app
app.mount('#app')
