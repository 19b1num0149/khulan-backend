<script setup>
import { computed } from 'vue'

const props = defineProps({ status: Number })

const title = computed(() => {
  return {
    503: 'Service Unavailable',
    500: 'Server Error',
    404: 'Page Not Found',
    403: 'Forbidden',
  }[props.status]
})

const description = computed(() => {
  return {
    503: 'Sorry, we are doing some maintenance. Please check back soon.',
    500: 'Whoops, something went wrong on our servers.',
    404: 'Sorry, the page you are looking for could not be found.',
    403: 'Sorry, you are forbidden from accessing this page.',
  }[props.status]
})

const back = () => {
   history.back();
}
</script>

<template>
   <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
      <div class="mx-auto max-w-screen-sm text-center">
         <h1 class="mb-4 text-6xl tracking-tight font-extrabold lg:text-8xl text-primary-600 dark:text-primary-500">
            {{ status }}
         </h1>
         <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">{{ title }}</p>
         <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">{{ description }}</p>
         <a @click="back" class="inline-flex text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900 my-4">
            {{ $t('back') }}
         </a>
      </div>
   </div>
</template>