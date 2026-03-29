import { defineStore } from 'pinia'

export const useTransactionStore = defineStore('transactions', {
  state: () => ({
    transactions: [
      // mock
      {
        id: 1,
        type: 'credit',
        description: 'Saldo inicial',
        amount: 1500,
        createdAt: '2026-03-28T09:00:00',
      },
      {
        id: 2,
        type: 'debit',
        description: 'Pagamento enviado',
        amount: 219.5,
        createdAt: '2026-03-28T11:45:00',
      },
    ],
  }),
  actions: {
    setTransactions(items) {
      this.transactions = items
    },
  },
})