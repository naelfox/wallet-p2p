import { createApp } from 'vue'
import PrimeVue from 'primevue/config'
import Aura from '@primeuix/themes/aura'
import 'primeicons/primeicons.css'
import './style.css'
import App from './App.vue'
import router from './router'
import { useAuthStore } from './stores/authStore'
import { pinia } from './stores'

const app = createApp(App)

app.use(pinia)
app.use(router)
app.use(PrimeVue, {
	ripple: true,
	theme: {
		preset: Aura,
		options: {
			darkModeSelector: false,
		},
	},
})

useAuthStore(pinia).initialize()

app.mount('#app')
