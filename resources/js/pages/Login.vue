<script setup>
    import { useForm } from '@inertiajs/vue3'
    import { Head } from '@inertiajs/vue3'
    
    const props = defineProps({ flash: Object })

    const form = useForm({
        email: '',
        password: ''
    })

    function hideNotification() {
        props.flash.invalid = '';
    }

    function submit() {
        hideNotification();
        form.errors = {};
        form.post('/auth', {
            resetOnSuccess: false,
            preserveScroll: true,
        })
    }

</script>

<template>
    <div>
        <Head :title="$t('loginHead')" />            
        <section class="bg-gray-50 dark:bg-gray-900">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">      
                <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            {{ $t('loginTitle') }}
                        </h1>
                        <transition name="fade" mode="out-in" appear>                        
                            <alert 
                                v-if="flash.invalid"
                                type="danger">{{ flash.invalid }}</alert>
                        </transition>    
                        <form class="space-y-4 md:space-y-6" @submit.prevent="submit">
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('email') }}</label>
                                <input 
                                        type="email" 
                                        name="email" 
                                        id="email" 
                                        v-model="form.email"
                                        autocomplete="username"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " 
                                        :class="[{ 'border-red-500': form.errors.email }]"
                                        placeholder="name@company.com">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.email">{{ form.errors.email }}</p>
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('password') }}</label>
                                <input 
                                    type="password" 
                                    name="password"
                                    autocomplete="current-password"
                                    id="password" 
                                    placeholder="••••••••" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    :class="[{ 'border-red-500': form.errors.password }]"
                                    v-model="form.password">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.password">{{ form.errors.password }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="remember" 
                                                aria-describedby="remember" 
                                                type="checkbox" 
                                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="remember" class="text-gray-500 dark:text-gray-300">{{ $t('rememberPassword') }}</label>
                                    </div>
                                </div>                      
                            </div>
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="w-full text-white text-center"               
                                :class="[{ 'bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800' : !form.processing },
                                        { 'bg-blue-400 dark:bg-blue-500 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5' : form.processing }]">{{ $t('signIn') }}</button>                 
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style>
/* we will explain what these classes do next! */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
