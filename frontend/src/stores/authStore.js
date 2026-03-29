import {
  defineStore
} from 'pinia'
import * as authService from '@/services/authService'

const readStoredUser = () => {
  const storedUser = localStorage.getItem('user')

  if (!storedUser) {
    return null
  }

  try {
    return JSON.parse(storedUser)
  } catch {
    localStorage.removeItem('user')
    return null
  }
}

const extractSession = (payload) => {
  const responseData = payload?.data ?? payload ?? {}
  const session = responseData?.data ?? responseData

  return {
    token: session.token ?? null,
    user: session.user ?? null,
  }
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token'),
    user: readStoredUser(),
    loading: false
  }),

  getters: {
    isAuthenticated: (state) => Boolean(state.token),
  },

  actions: {
    async login(payload) {
      this.loading = true

      try {
        const res = await authService.login(payload)
        const {
          token,
          user
        } = extractSession(res)

        if (!token) {
          throw new Error('Token de autenticacao nao encontrado na resposta do login')
        }

        this.token = token
        this.user = user

        localStorage.setItem('token', token)

        if (user) {
          localStorage.setItem('user', JSON.stringify(user))
        } else {
          localStorage.removeItem('user')
        }

        return res
      } finally {
        this.loading = false
      }
    },

    logout() {
      this.token = null
      this.user = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }
})