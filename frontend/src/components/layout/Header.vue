<script setup>
import { ref } from 'vue'
import router from '../../router';
import Card from 'primevue/card'
import Button from 'primevue/button'
import { useAuthStore } from '../../stores/authStore'

const productName = 'Wallet P2P'
const authStore = useAuthStore()

const handleLogout = async () => {

  try {
    await authStore.logout()
  } finally {
    router.push({ name: 'login' })
  }
}
</script>

<template>
  <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between md:gap-6">
      <div class="space-y-1.5">
        <span class="text-sm font-medium text-slate-500">Bem-vindo ao</span>

        <router-link to="/dashboard" class="inline-block">
          <h1 class="text-3xl font-semibold text-slate-950">
            {{ productName }}
          </h1>
        </router-link>

        <p class="text-sm leading-6 text-slate-600">
          Sua carteira digital peer-to-peer.
        </p>
      </div>

      <Card class="w-full max-w-md self-stretch rounded-3xl border border-slate-200 bg-white shadow-none md:self-auto">
        <template #title>
          <span class="text-base font-semibold text-slate-900">Usuario</span>
        </template>
        <template #content>
          <div class="space-y-3.5 text-sm text-slate-600">
            <p><strong class="font-medium text-slate-900">Nome:</strong> {{ authStore.user?.name ?? 'Nao definido' }}</p>
            <p><strong class="font-medium text-slate-900">E-mail:</strong> {{ authStore.user?.email ?? 'Nao definido' }}</p>
            <div>
              <Button
                label="Sair"
                severity="danger"
                text
                @click="handleLogout"
              />
            </div>
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>