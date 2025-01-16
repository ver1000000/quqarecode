<template>
  <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" sm="8" md="6" lg="4" align-self="center">
      <h1 class="text-h3 mb-10 text-center">Кукарекод генератор</h1>
      <v-img align="center" class="ml-auto mr-auto mb-10" :src="qrCodeDataUrl || '/hero.png'" alt="QR Code"
        max-width="200">
      </v-img>
      <v-form @submit.prevent="generateQRCode" v-model="isFormValid">
        <v-text-field label="Ссылка" v-model="url" :rules="urlRules" variant="solo"
          hint="Введите валидный URL (например, https://example.com)" persistent-hint>
        </v-text-field>
        <v-btn class="mt-2" block type="submit" color="secondary" size="large">
          Сгенерировать кукарекод
        </v-btn>
      </v-form>
    </v-col>
  </v-row>
</template>

<script setup>
import { ref, inject } from 'vue'
import QRCode from 'qrcode'
const eventTracker = inject('$eventTracker')

const url = ref('')
const qrCodeDataUrl = ref('')
const isFormValid = ref(false)

const urlRules = [
  v => !!v || 'URL обязателен',
  v => {
    try {
      new URL(v)
      return true
    } catch (e) {
      return 'Введите валидный URL'
    }
  }
]

const generateQRCode = async () => {
    try {
      if (isFormValid.value) {
        qrCodeDataUrl.value = await QRCode.toDataURL(url.value)
        eventTracker.sendEvent('qr_code_generated', { url: url.value })
      }
    } catch (error) {
        console.error('Error generating QR code:', error)
    }
}
</script>