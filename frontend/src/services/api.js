import axios from 'axios'

import router from '@/router'
import { useAuthStore } from '@/stores/authStore'
import { pinia } from '@/stores'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
})

api.interceptors.request.use(config => {
  const authStore = useAuthStore(pinia)

  if (authStore.token) {
    config.headers.Authorization = `Bearer ${authStore.token}`
  }

  return config
})

api.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      const authStore = useAuthStore(pinia)
      authStore.logout()

      if (router.currentRoute.value.name !== 'login') {
        router.push({ name: 'login' })
      }
    }

    return Promise.reject(error)
  }
)

export default api