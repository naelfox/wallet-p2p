const TOKEN_KEY = 'token'
const USER_KEY = 'user'
const AUTH_SESSION_EVENT = 'auth-session-changed'

const buildSession = (token, user) => ({
  token,
  user,
})

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

const dispatchSessionChange = (session) => {
  if (typeof window === 'undefined') {
    return
  }

  window.dispatchEvent(new CustomEvent(AUTH_SESSION_EVENT, {
    detail: session,
  }))
}

export const readSession = () => buildSession(
  localStorage.getItem(TOKEN_KEY),
  readStoredUser(),
)

export const writeSession = ({ token, user }) => {
  if (token) {
    localStorage.setItem(TOKEN_KEY, token)
  } else {
    localStorage.removeItem(TOKEN_KEY)
  }

  if (user) {
    localStorage.setItem(USER_KEY, JSON.stringify(user))
  } else {
    localStorage.removeItem(USER_KEY)
  }

  const session = buildSession(token ?? null, user ?? null)
  dispatchSessionChange(session)

  return session
}

export const clearSession = () => writeSession({
  token: null,
  user: null,
})

export const onSessionChange = (handler) => {
  if (typeof window === 'undefined') {
    return () => {}
  }

  const listener = (event) => {
    handler(event.detail ?? readSession())
  }

  window.addEventListener(AUTH_SESSION_EVENT, listener)

  return () => {
    window.removeEventListener(AUTH_SESSION_EVENT, listener)
  }
}