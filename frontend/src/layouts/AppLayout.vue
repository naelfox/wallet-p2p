<script setup>
import { RouterView } from 'vue-router'

import Header from '../components/layout/Header.vue'
import Navbar from '../components/layout/Navbar.vue'
</script>

<template>
  <div class="mx-auto flex min-h-screen w-[min(1120px,calc(100%-32px))] flex-col gap-5 py-6 max-md:w-[calc(100%-24px)] md:gap-6 md:py-8">
    <Header />
    <Navbar />
    <main class="flex flex-1 flex-col">
      <RouterView />
    </main>
  </div>
</template>