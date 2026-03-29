import { defineStore } from 'pinia'
import * as transactionHistoryService from '@/services/transactionHistoryService'

const createDefaultFilters = () => ({
  page: 1,
  type: null,
  start_date: null,
  end_date: null,
  per_page: 10,
})

const useTransactionHistoryStore = defineStore('transactions', {
  state: () => ({
    transactions: [],
    meta: {
      current_page: 1,
      per_page: 10,
      total: 0,
    },
    loading: false,
    filters: createDefaultFilters(),
  }),
  actions: {
   async fetchTransactions() {
      this.loading = true
      try {
        const res = await transactionHistoryService.getTransactions(this.filters)
        this.transactions = res.data?.data ?? []
        this.meta = {
          current_page: res.data?.meta?.current_page ?? this.filters.page,
          per_page: res.data?.meta?.per_page ?? this.meta.per_page,
          total: res.data?.meta?.total ?? 0,
        }
      } finally {
        this.loading = false
      }
    },

    setFilter(filter) {
      this.filters = { ...this.filters, ...filter, page: 1 }
      this.fetchTransactions()
    },

    setPagination({ page, per_page }) {
      this.filters.page = page
      this.filters.per_page = per_page
      this.fetchTransactions()
    },

    resetFilters() {
      this.filters = createDefaultFilters()
      this.fetchTransactions()
    }
  },
})

export { useTransactionHistoryStore }
export const useTransactionStore = useTransactionHistoryStore