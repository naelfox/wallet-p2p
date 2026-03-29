<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'

import Card from 'primevue/card'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Message from 'primevue/message'


import { useAuthStore } from '@/stores/authStore'

const authStore = useAuthStore()
const error = ref(null)
const router = useRouter()


const form = reactive({
  name: '',
  email: '',
  password: '',
})

const submit = async () => {
  error.value = null

  try {
    await authStore.register({
      name: form.name,
      email: form.email,
      password: form.password
    })

    alert('Cadastro realizado com sucesso, faça login para acessar sua conta')
    router.push({ name: 'login' })

  } catch (e) {
    error.value = e.response?.data?.message || e.message || 'Erro ao fazer o cadastro'
  }
}
</script>

<template>
  <section class="mx-auto max-w-xl">
    <Card
      class="overflow-hidden rounded-[28px] border border-slate-900/8 bg-white/85 shadow-[0_18px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl">
      <template #title>Criar conta</template>
      <template #content>
        <div class="space-y-6">
          <p class="text-sm leading-6 text-slate-600">
            Cadastro simples para organizar o fluxo de autenticacao no frontend.
          </p>

          <div class="space-y-4">
            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-700">Nome</label>
              <InputText v-model="form.name" placeholder="Seu nome" class="w-full" />
            </div>

            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-700">E-mail</label>
              <InputText v-model="form.email" placeholder="voce@exemplo.com" class="w-full" />
            </div>

            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-700">Senha</label>
              <InputText v-model="form.password" type="password" placeholder="Crie uma senha" class="w-full" />
            </div>
          </div>
          <div class="space-y-3">

            <Button label="Cadastrar" severity="contrast" class="w-full" @click="submit" />

            <Message v-if="error" severity="error">
              {{ error }}
            </Message>
          </div>

          <div class="border-t border-slate-200 pt-4 text-sm text-slate-600">
            <router-link :to="{ name: 'login' }" class="font-medium text-slate-900 transition hover:text-slate-700">
              Voltar
            </router-link>
          </div>
        </div>
      </template>
    </Card>
  </section>
</template>