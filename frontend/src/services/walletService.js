import api from './api'

export const getBalance = () => api.get('/wallet/balance')