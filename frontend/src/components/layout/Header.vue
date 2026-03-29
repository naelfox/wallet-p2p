<script setup>
import router from '../../router';
import Card from 'primevue/card'
import { useAuthStore } from '../../stores/authStore'

const productName = 'Wallet P2P'
const authStore = useAuthStore()

const handleLogout = () => {
  authStore.logout()
  router.push({ name: 'login' })
}
</script>

<template>
  <div class="flex flex-col gap-5 rounded-[28px] border border-slate-800 bg-slate-950 p-8 text-white shadow-[0_18px_40px_rgba(2,6,23,0.45)]">
    <span class="text-sm uppercase tracking-[0.24em] text-white/70">Bem vindo ao</span>
    
    <router-link to="/dashboard">
      <h1 class="text-4xl font-semibold text-white">
        {{ productName }}
      </h1> 
    </router-link>

    <p class="text-white/80">
      Sua carteira digital peer-to-peer.
    </p>

    <Card
      class="overflow-hidden rounded-[28px] border border-slate-800 bg-slate-900 shadow-[0_18px_40px_rgba(2,6,23,0.35)] backdrop-blur-xl">
      <template #title>
        <span class="text-white">Usuario</span>
      </template>
      <template #content>
        <div class="space-y-2 text-sm leading-6 text-white/80">
          <p><strong class="text-white">Nome:</strong> {{ authStore.user?.name ?? 'Nao definido' }}</p>
          <p><strong class="text-white">E-mail:</strong> {{ authStore.user?.email ?? 'Nao definido' }}</p>
          <button
            type="button"
            class="text-sm font-medium text-white transition hover:text-amber-300"
            @click="handleLogout">
            Sair
          </button>
        </div>
      </template>
    </Card>
  </div>
</template>