<script setup>
import { reactive } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import Input from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import { ref } from 'vue'
import Message from 'primevue/message'
import { useTransferStore } from '@/stores/transferStore'

const loading = ref(false);
const error = ref(null)

const form = reactive({
  recipient_email: '',
  amount: '',
})

const store = useTransferStore()

const submit = async (e) => {
  loading.value = true

  try {
    await store.transfer({
      recipient_email: form.recipient_email,
      amount: Math.round(form.amount * 100)
    })

    form.recipient_email = ''
    form.amount = ''

    alert('Transferência realizada')

  } catch (e) {
    error.value = e.response?.data?.message || e.message || 'Erro na transferência'

  } finally {
    loading.value = false
  }
}

</script>

<template>
  <section class="mx-auto max-w-2xl">
    <Card
      class="overflow-hidden rounded-[28px] border border-slate-900/8 bg-white/85 shadow-[0_18px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl">
      <template #title>Nova transferencia</template>
      <template #content>
        <div class="space-y-6">
          <p class="text-sm leading-6 text-slate-600">
            Informe o destinatario e o valor para concluir a transferencia.
          </p>

          <div class="space-y-4">
            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-700">Destinatario</label>
              <Input type="email" v-model="form.recipient_email" placeholder="E-mail" class="w-full" />
            </div>

            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-700">Valor</label>
              <InputNumber v-model="form.amount" inputId="currency-brazil" mode="currency" currency="BRL" locale="pt-BR"
                fluid />
            </div>
          </div>

          <div class="space-y-3">
            <Button label="Transferir" severity="contrast" @click="submit" :disabled="loading" class="w-full sm:w-auto" />

            <Message v-if="error" severity="error">
              {{ error }}
            </Message>
          </div>
        </div>
      </template>
    </Card>
  </section>
</template>