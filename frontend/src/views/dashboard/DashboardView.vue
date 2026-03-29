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
      <div class="space-y-4">
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
        <div class="grid gap-4 md:grid-cols-2">
          <ul>
            <li v-for="transaction in store.transactions" :key="transaction.id">
              <div> {{ formatTransactionType(transaction.type) }} - {{ formatCurrency(transaction.amount) }} </div>
           
              de/para: {{ transaction.recipient.name }} - {{ formatDate(transaction.created_at) }}
            </li>
               <br>
          </ul>



        </div>
      </div>
    </template>
  </Card>


</template>