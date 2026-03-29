import api from './api'

export const getBalance = () => api.get('/wallet/balance')
export const transfer = (payload) => api.post('/wallet/transfer', payload)