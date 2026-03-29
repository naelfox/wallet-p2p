<script setup>
import { useRoute, useRouter } from 'vue-router'
import Button from 'primevue/button'

const route = useRoute()
const router = useRouter()

const navigationItems = [
  { label: 'Dashboard', name: 'dashboard' },
  { label: 'Transferir', name: 'transfer' },
  { label: 'Transacoes', name: 'transactions' },
]

const isActive = (name) => route.name === name
</script>

<template>
  <div class="flex flex-wrap gap-3">
    <Button
      v-for="item in navigationItems"
      :key="item.name"
      :label="item.label"
      :severity="isActive(item.name) ? 'contrast' : 'secondary'"
      :outlined="!isActive(item.name)"
      @click="router.push({ name: item.name })"
    />
  </div>
</template>