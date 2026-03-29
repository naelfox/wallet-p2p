<script setup>
import { reactive } from 'vue'
import Card from 'primevue/card'
import Button from '../../components/ui/Button.vue'
import Input from '../../components/ui/Input.vue'

const form = reactive({
  name: '',
  email: '',
  password: '',
})
</script>

<template>
  <section class="mx-auto max-w-xl">
    <Card
      class="overflow-hidden rounded-[28px] border border-slate-900/8 bg-white/85 shadow-[0_18px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl">
      <template #title>Criar conta</template>
      <template #content>
        <div class="space-y-4">
          <p class="text-sm leading-6 text-slate-600">
            Cadastro simples para organizar o fluxo de autenticacao no frontend.
          </p>

          <div class="space-y-2">
            <label class="text-sm font-medium text-slate-700">Nome</label>
            <Input v-model="form.name" placeholder="Seu nome" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-slate-700">E-mail</label>
            <Input v-model="form.email" placeholder="voce@exemplo.com" />
          </div>

          <div class="space-y-2">
            <label class="text-sm font-medium text-slate-700">Senha</label>
            <Input v-model="form.password" type="password" placeholder="Crie uma senha" />
          </div>

          <Button label="Cadastrar" severity="contrast" class="w-full" />
        </div>
        
        <div class="space-y-2">
          <router-link :to="{ name: 'login' }" class="text-sm font-medium text-white hover:text-green-600">
            Voltar
          </router-link>
        </div>
      </template>
    </Card>
  </section>
</template>