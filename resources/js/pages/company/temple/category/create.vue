<script setup>
    import PageTitle from '@/components/PageTitle.vue';
    import { useForm, Link, Head } from '@inertiajs/vue3';

    const props = defineProps({ 
        flash: Object,
        types: Object
    })

    const form = useForm({
        name: '',
        description: '',
        type: ''
    })

    function reset() {
        form.reset()
    }

    const submit = () => {
        form.post('/company/temple/category', {
            preserveScroll: true,
            onSuccess: () => reset(),
        })
    }

</script>

<template>

    <div>
        <Head :title="$t('templeCategoryAdd')" />
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <page-title 
                :title="$t('templeCategory')"
                :subtitle="$t('templeCategoryAdd')"></page-title>

            <div class="max-w-[600px] p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <transition name="fade" mode="out-in" appear>
                    <alert 
                        v-if="flash.success"
                        type="success">{{ flash.success }}</alert>
                </transition> 
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $t('templeCategoryAdd') }}</h5>
                <hr class="mt-4 mb-4">                
                <form @submit.prevent="submit">
                    <!-- body -->
                    <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <div class="mb-6">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('templeCategoryName') }}</label>
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
                            <label for="type" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('templeCategoryType') }}</label>
                            <select id="type"                                         
                                    v-model="form.type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    :class="[{ 'border-red-500': form.errors.type }]">
                               <option value="">{{ $t('pleaseSelect') }}</option>
                               <option v-for="(item, index) in types" :key="index" :value="item.id">{{ item.name }}</option>                  
                            </select>               
                            <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.type">{{ form.errors.type }}</p>
                        </div>
                        <div class="mb-6">
                            <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('templeCategoryDesc') }}</label>
                            <textarea
                                autocomplete="off"
                                v-model="form.description"
                                :class="[{ 'border-red-500': form.errors.description }]"
                                id="desc"
                                rows="2" 
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder=""></textarea>
                            <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.description">{{ form.errors.description }}</p>
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
                            {{ $t('save') }}
                        </button>
                        <Link class="py-2.5 px-5 ml-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" href="/company/temple/category">{{ $t('back') }}</Link>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

</template>