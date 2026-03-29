import { defineStore } from 'pinia'

export const useWalletStore = defineStore('wallet', {
  state: () => ({
    balance: 1280.5,
  }),
  actions: {
    setBalance(value) {
      this.balance = value
    },
  },
})