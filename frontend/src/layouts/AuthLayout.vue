<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <div class="mx-auto flex min-h-screen w-[min(1120px,calc(100%-32px))] items-center justify-center py-8 max-md:w-[calc(100%-24px)] max-md:py-5">
    <main class="w-full">
      <RouterView />
    </main>
  </div>
</template>