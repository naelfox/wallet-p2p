<script setup>
import Card from 'primevue/card'
import Tag from 'primevue/tag'
import { storeToRefs } from 'pinia'
import { useTransactionStore } from '../../stores/transactionStore'
import { formatCurrency, formatDate } from '../../utils/format'

const transactionStore = useTransactionStore()
const { transactions } = storeToRefs(transactionStore)
</script>

<template>
  <section>
    <Card class="overflow-hidden rounded-[28px] border border-slate-900/8 bg-white/85 shadow-[0_18px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl">
      <template #title>Historico de transacoes</template>
      <template #content>
        <div class="space-y-3">
          <article
            v-for="transaction in transactions"
            :key="transaction.id"
            class="flex flex-col gap-3 rounded-3xl border border-slate-900/8 bg-slate-50 p-4 md:flex-row md:items-center md:justify-between"
          >
            <div>
              <p class="font-medium text-slate-950">{{ transaction.description }}</p>
              <p class="text-sm text-slate-500">{{ formatDate(transaction.createdAt) }}</p>
            </div>

            <div class="flex items-center gap-3">
              <Tag :severity="transaction.type === 'credit' ? 'success' : 'danger'" :value="transaction.type" />
              <strong class="text-slate-950">{{ formatCurrency(transaction.amount) }}</strong>
            </div>
          </article>
        </div>
      </template>
    </Card>
  </section>
</template>