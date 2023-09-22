<script setup>

defineProps({
    title: String,
    subtitle: String
})

</script>
<template>
    <div>
      <!-- text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400 -->
      <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white md:text-3xl">
        <span class="text-primary-600">{{ title }}</span>
      </h3>
      <p class="font-normal text-gray-500 lg:text-base dark:text-gray-400 pb-4">{{ subtitle }}</p>
    </div>
</template>