import {
	defineStore
} from 'pinia'
import * as walletService from '@/services/walletService'

export const useWalletStore = defineStore('wallet', {
	state: () => ({
		balance: 0,
	}),

	actions: {
		async fetchBalance() {
			try {
				const res = await walletService.getBalance()

				this.balance = res.data.balance
			} catch (e) {
				console.error(e)
				throw e
			}
		}
	}
})
