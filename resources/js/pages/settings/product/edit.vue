<script setup>
    import PageTitle from '@/components/PageTitle.vue';
    import { useForm, Head, Link } from '@inertiajs/vue3';

    const props = defineProps({ flash: Object, 
                                product: Object,
                                prev: String })

    const form = useForm({
        name: props.product.name,
        description: props.product.description,
        _prev: props.prev
    })

    function submit() {
        form.put(`/settings/product/${props.product.id}`, {
            preserveScroll: true
        })
    }

</script>

<template>

    <div>
        <Head>
            <title>{{ $t('settingsProductEdit') }}</title>
        </Head>
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <page-title 
                :title="$t('settingsProduct')"
                :subtitle="$t('settingsProductEdit')"></page-title>

            <div class="max-w-[600px] p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">                
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $t('settingsProductEdit') }}</h5>
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
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('productListName') }}</label>
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
                            <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('productListDesc') }}</label>
                            <textarea
                                autocomplete="off"
                                v-model="form.description"
                                :class="[{ 'border-red-500': form.errors.description }]"
                                id="desc"
                                rows="4" 
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder=""></textarea>

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
                        <Link :href="prev" class="py-2.5 px-5 ml-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" as="button">{{ $t('back') }}</Link>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

</template>