import api from './api'

export const transfer = (payload) => api.post('/wallet/transfer', payload)