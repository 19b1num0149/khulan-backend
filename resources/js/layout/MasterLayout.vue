<script setup>
  import { initFlowbite } from "flowbite";
  import { onMounted } from 'vue'
  import Navbar from './modules/Navbar.vue'
  import Sidebar from './modules/Sidebar.vue'
  import ConfirmationModal from "@/components/ConfirmationModal.vue";

  onMounted(() => {
    initFlowbite();
  })
</script>

<template>
    <!-- page-wrapper Start-->
    <div class="antialiased bg-gray-50 dark:bg-gray-900 min-h-screen">

      <!-- Page Header Start-->
      <Navbar></Navbar>
      <!-- Page Header Ends -->

      <!-- Page Sidebar Start-->
      <Sidebar></Sidebar>
      <!-- Page Sidebar Ends-->

      <!-- Confirmation Modal  -->
      <ConfirmationModal />

      <!-- Page Body Start-->
      <transition name="fade" mode="out-in" appear>
        <main class="p-4 md:ml-64 pt-28 h-auto" :key="$page.url">
            <slot />     
        </main>
      </transition>
    </div>    
</template>