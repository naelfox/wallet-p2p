import {
    defineStore
} from 'pinia'
import * as dashboardService from '@/services/dashboardService'

export const useDashboardStore = defineStore('dashboard', {
    state: () => ({
        balance: 0,
        transactions: [],
    }),

    actions: {
        async fetchDashboard() {
            try {
                const res = await dashboardService.getDashboardData()

                this.balance = res.data.balance
                this.transactions = res.data.latest_transactions
            } catch (e) {
                console.error(e)
                throw e
            }
        }
    }
})