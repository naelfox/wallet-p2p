<script setup>
import { RouterView } from 'vue-router'

import Header from '../components/layout/Header.vue'
import Navbar from '../components/layout/Navbar.vue'
</script>

<template>
  <div class="mx-auto min-h-screen w-[min(1120px,calc(100%-32px))] py-8 max-md:w-[calc(100%-24px)] max-md:py-5">
    <Header />
    <Navbar />
    <main class="mt-6">
      <RouterView />
    </main>
  </div>
</template>