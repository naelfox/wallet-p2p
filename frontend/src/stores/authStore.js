import { defineStore } from 'pinia'
import * as authService from '@/services/authService'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token'),
    loading: false
  }),

  actions: {
    async login(payload) {
      this.loading = true

      try {
        const res = await authService.login(payload)

        this.token = res.data.token
        localStorage.setItem('token', this.token)

        return res
      } finally {
        this.loading = false
      }
    },

    logout() {
      this.token = null
      localStorage.removeItem('token')
    }
  }
})