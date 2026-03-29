import {
  defineStore
} from 'pinia'
import * as authService from '@/services/authService'

const TOKEN_KEY = 'token'
const USER_KEY = 'user'

const readStoredUser = () => {
  const storedUser = localStorage.getItem(USER_KEY)

  if (!storedUser) {
    return null
  }

  try {
    return JSON.parse(storedUser)
  } catch {
    localStorage.removeItem(USER_KEY)
    return null
  }
}

const readStoredSession = () => ({
  token: localStorage.getItem(TOKEN_KEY),
  user: readStoredUser(),
})

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
    token: null,
    user: null,
  }),

  getters: {
    isAuthenticated: (state) => Boolean(state.token),
  },

  actions: {
    applySession(session) {
      this.token = session.token
      this.user = session.user
    },

    initialize() {
      this.applySession(readStoredSession())
    },

    persistSession() {
      if (this.token) {
        localStorage.setItem(TOKEN_KEY, this.token)
      } else {
        localStorage.removeItem(TOKEN_KEY)
      }

      if (this.user) {
        localStorage.setItem(USER_KEY, JSON.stringify(this.user))
      } else {
        localStorage.removeItem(USER_KEY)
      }
    },

    setSession({ token, user }) {
      this.applySession({
        token: token ?? null,
        user: user ?? null,
      })
      this.persistSession()
    },

    clearSession() {
      this.setSession({
        token: null,
        user: null,
      })
    },

    async login(payload) {
      const res = await authService.login(payload)
      const {
        token,
        user
      } = extractSession(res)

      if (!token) {
        throw new Error('Token de autenticacao nao encontrado na resposta do login')
      }

      this.setSession({ token, user })

      return res
    },

    async register(data) {
      return await authService.register(data)
    },

    logout() {
      this.clearSession()
    }
  }
})