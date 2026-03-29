<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import Card from 'primevue/card'
import Message from 'primevue/message'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'

import { useAuthStore } from '@/stores/authStore'

const authStore = useAuthStore()
const router = useRouter()
const error = ref(null)

const form = reactive({
  email: '',
  password: '',
})

const submit = async () => {
  error.value = null

  try {
    await authStore.login({
      email: form.email,
      password: form.password
    })

    router.push({ name: 'home' })
  } catch (e) {
    error.value = e.response?.data?.message || e.message || 'Erro ao fazer login'
  }
}
</script>

<template>
  <section class="mx-auto max-w-xl">
    <Card
      class="overflow-hidden rounded-[28px] border border-slate-900/8 bg-white/85 shadow-[0_18px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl">
      <template #title>Login</template>
      <template #content>
        <div class="space-y-6">
          <p class="text-sm leading-6 text-slate-600">
            Entre com sua conta para acessar dashboard, saldo e transferencias.
          </p>

          <div class="space-y-4">
            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-700">E-mail</label>
              <InputText v-model="form.email" placeholder="voce@exemplo.com" class="w-full" />
            </div>

            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-700">Senha</label>
              <InputText v-model="form.password" type="password" placeholder="Sua senha" class="w-full" />
            </div>
          </div>

          <div class="space-y-3">
            <Button label="Entrar" severity="contrast" class="w-full" @click="submit" />

            <Message v-if="error" severity="error">
              {{ error }}
            </Message>
          </div>

          <div class="border-t border-slate-200 pt-4 text-sm text-slate-600">
            <router-link :to="{ name: 'register' }" class="font-medium text-slate-900 transition hover:text-slate-700">
              Registrar
            </router-link>
          </div>
        </div>

      </template>
    </Card>
  </section>
</template>