<script setup>
import { onMounted } from 'vue'
import Card from 'primevue/card'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import Paginator from 'primevue/paginator'
import { useTransactionHistoryStore } from '@/stores/transactionHistoryStore'
import { formatCurrency, formatDate, formatTransactionType } from '@/utils/format'

const store = useTransactionHistoryStore()
const rowsPerPageOptions = [5, 10, 20, 50]

onMounted(() => {
  store.fetchTransactions()
})
</script>

<template>
  <section>
    <Card
      class="overflow-hidden rounded-[28px] border border-slate-900/8 bg-white/85 shadow-[0_18px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl">
      <template #title>Histórico de transações</template>
      <template #content>
        <div class="space-y-6">
          <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div class="space-y-1">
              <p class="text-sm font-medium text-slate-700">Filtros</p>
              <p class="text-sm text-slate-500">Refine a listagem por tipo e periodo.</p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap md:justify-end">
              <select
                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700"
                :value="store.filters.type ?? ''"
                @change="e => store.setFilter({ type: e.target.value || null })">
                <option value="">Todos</option>
                <option value="debit">Enviado</option>
                <option value="credit">Recebido</option>
              </select>

              <input
                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700"
                type="date"
                :value="store.filters.start_date ?? ''"
                @change="e => store.setFilter({ start_date: e.target.value || null })" />
              <input
                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700"
                type="date"
                :value="store.filters.end_date ?? ''"
                @change="e => store.setFilter({ end_date: e.target.value || null })" />
              <button
                type="button"
                class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                @click="store.resetFilters()">
                Limpar filtros
              </button>
            </div>
          </div>

          <div class="space-y-4">
            <DataTable :value="store.transactions" :loading="store.loading">
              <Column header="Data">
                <template #body="{ data }">
                  {{ formatDate(data.created_at) }}
                </template>
              </Column>

              <Column header="Tipo">
                <template #body="{ data }">
                  <span :class="data.type === 'credit' ? 'text-green' : 'text-red'">
                    {{ formatTransactionType(data.type) }}
                  </span>
                </template>
              </Column>

              <Column field="amount" header="Valor">
                <template #body="{ data }">
                  {{ formatCurrency(data.amount) }}
                </template>
              </Column>

              <Column header="Usuário">
                <template #body="{ data }">
                  {{ data.type === 'credit' ? data.sender.name : data.recipient.name }}
                </template>
              </Column>
            </DataTable>

            <Paginator
              :first="(store.meta.current_page - 1) * store.meta.per_page"
              :rows="store.meta.per_page"
              :totalRecords="store.meta.total"
              :rowsPerPageOptions="rowsPerPageOptions"
              @page="e => store.setPagination({ page: e.page + 1, per_page: e.rows })" />
          </div>
        </div>
      </template>
    </Card>
  </section>
</template>