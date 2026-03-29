<script setup>
import Card from 'primevue/card'
import { formatCurrency, formatDate, formatTransactionType } from '@/utils/format'
import { useDashboardStore } from '@/stores/dashboardStore'
import { onMounted } from 'vue';

const store = useDashboardStore()

onMounted(() => {
  store.fetchDashboard()

})


</script>

<template>
  <Card
    class="overflow-hidden rounded-[28px] border border-slate-900/8 bg-white/85 shadow-[0_18px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl">
    <template #title>Dashboard</template>
    <template #content>
      <div class="space-y-6">
        <p class="text-base leading-7 text-slate-600">
          Base pronta para conectar seus dados de saldo, transferencias e historico do backend.
        </p>

        <div class="grid gap-4 md:grid-cols-2">
          <article class="rounded-3xl border border-slate-900/8 bg-slate-50 p-5">
            <span class="text-sm text-slate-500">Saldo atual</span>
            <strong class="mt-2 block text-2xl font-semibold text-slate-950">{{ formatCurrency(store.balance)
            }}</strong>
          </article>
        </div>

        <section class="space-y-4">
          <div class="space-y-1">
            <h2 class="text-lg font-semibold text-slate-900">Transferencias recentes</h2>
            <p class="text-sm text-slate-500">Movimentacoes mais recentes da sua conta.</p>
          </div>

          <ul class="space-y-3">
            <li
              v-for="transaction in store.transactions"
              :key="transaction.id"
              class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-600">
              <div>
                {{ formatCurrency(transaction.amount) }} {{ formatTransactionType(transaction.type).toLowerCase() }}
                <template v-if="transaction.type == 'debit'">para {{ transaction.recipient.name }}</template>
                <template v-else-if="transaction.type == 'credit'">de {{ transaction.sender.name }}</template>
                as {{ formatDate(transaction.created_at) }}
              </div>
            </li>

            <li
              v-if="!store.transactions.length"
              class="rounded-2xl border border-dashed border-slate-200 px-4 py-5 text-sm text-slate-500">
              Nenhuma transferencia encontrada.
            </li>
          </ul>
        </section>
      </div>
    </template>
  </Card>
</template>