<script setup>
   import PageTitle from '@/components/PageTitle.vue';
   import { useForm, Head } from '@inertiajs/vue3';

   const props = defineProps({ flash: Object, 
                               user: Object })

   const form = useForm({
      id: props.user.id,
      name: props.user.name,
      email: props.user.email,
      password: ''
   })

   function submit() {
      form.post(`/settings/profile/${props.user.id}`, {
         preserveScroll: true
      })
   }
</script>

<template>

    <div>
        <Head>
            <title>{{ $t('settingsProfile') }}</title>
        </Head>
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <page-title 
                :title="$t('settingsProfile')"
                :subtitle="$t('settingsProfileEdit')"></page-title>

            <div class="max-w-[600px] p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">                
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $t('settingsProfileEdit') }}</h5>
                <hr class="mt-4 mb-4">
                <transition name="fade" mode="out-in" appear>
                    <alert 
                        v-if="flash.success"
                        type="success">{{ flash.success }}</alert>
                </transition> 
                <form @submit.prevent="submit">
                    <!-- body -->
                    <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <div class="mb-6">
                           <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('userName') }}</label>
                           <input 
                              type="text" 
                              id="name" 
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                              :class="[{ 'border-red-500': form.errors.name }]"
                              placeholder=""
                              v-model="form.name" 
                              autocomplete="off">
                           <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.name">{{ form.errors.name }}</p>
                        </div>
                        <div class="mb-6">
                           <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('userEmail') }}</label>
                           <input 
                               type="email" 
                               id="email" 
                               disabled
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                               :class="[{ 'border-red-500': form.errors.email }]"
                               placeholder=""
                               v-model="form.email" 
                               autocomplete="off">
                           <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.email">{{ form.errors.email }}</p>
                        </div>
                        <div class="mb-6">
                           <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('userPassword') }}</label>
                           <input 
                              type="password" 
                              id="password" 
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                              :class="[{ 'border-red-500': form.errors.password }]"
                              placeholder="********"
                              v-model="form.password" 
                              autocomplete="off">
                           <p class="mt-1 text-xs text-gray-500 dark:text-gray-400"> {{ $t('userProfilePasswordHelper') }} </p>
                           <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.password">{{ form.errors.password }}</p>
                        </div>
                    </div>                
                    <!-- Action -->
                    <div>
                        <button 
                            type="submit"
                            :disabled="form.processing"
                            :class="[{ 'bg-blue-400 dark:bg-blue-500 cursor-not-allowed text-sm' :  form.processing },
                                    { 'bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-sm w-full sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800': !form.processing}]"
                            class="text-white font-medium rounded-lg text-center px-5 py-2.5">
                            {{ $t('update') }}
                        </button>                        
                    </div>
                </form>
                
            </div>
        </div>
    </div>

</template>