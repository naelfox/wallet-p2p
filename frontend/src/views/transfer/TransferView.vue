<script setup>
import { reactive } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import Input from 'primevue/inputtext'


const form = reactive({
  payee: '',
  amount: '',
})
</script>

<template>
    <Card class="overflow-hidden rounded-[28px] border border-slate-900/8 bg-white/85 shadow-[0_18px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl">
      <template #title>Nova transferencia</template>
      <template #content>
        <div class="space-y-4">
          <div class="space-y-2">
            <label class="text-sm font-medium text-slate-700">Destinatario</label>
            <Input v-model="form.payee" placeholder="E-mail" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-slate-700">Valor</label>
            <Input v-model="form.amount" placeholder="0,00" />
          </div>

          <Button label="Transferir" severity="contrast" />
        </div>
      </template>
    </Card>

    
</template>