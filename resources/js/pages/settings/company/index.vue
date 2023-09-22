<script setup>
import PageTitle from '@/components/PageTitle.vue';
import { Link, Head, router } from '@inertiajs/vue3';
import { initFlowbite } from "flowbite";
import { onMounted, ref, watch } from 'vue';
import useEventsBus from '@/eventBus';

const { emit, bus } = useEventsBus()

const props = defineProps({
    listdata: Object,
    flash: Object,
    filters: Object
})

let search = ref(props.filters.search)
let _deleteId = ref('')

function filter() {
    router.get('/settings/company', { search: search.value }, { replace: true, preserveState: true })
}

function _setSelected(id) {
    _deleteId.value = id;
    emit('confirm-open')
}

function confirmDelete() {
    //emit('confirm-loading', true);
    router.delete(`/settings/company/${_deleteId.value}`, { 
        replace: true, 
        preserveState: true,
        onSuccess: () => {
            emit('confirm-row-deleted');
        } });
}

// Listening Event for confirmation.
watch(() => bus.value.get('confirm-delete'), () => {
    confirmDelete()
})

watch(() => bus.value.get('confirm-modal-closed'), () => {
    _deleteId.value = '';
})

onMounted(() => {
    initFlowbite();
})

</script>
<template>
    <Head :title="$t('settingsCompany')" />      
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <page-title 
            :title="$t('settingsCompany')"
            :subtitle="$t('settingsCompanyList')" />
        <transition name="fade" mode="out-in" appear>
            <alert 
                v-if="flash.success"
                type="success">{{ flash.success }}</alert>
        </transition> 
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <!-- filter section -->
                <div class="w-full md:w-1/2">
                    <form class="flex items-center" @submit.prevent="filter">
                        <label for="simple-search" class="sr-only">{{ $t('search') }}</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="simple-search"
                                v-model="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                :placeholder="$t('search')" >
                        </div>
                    </form>
                </div>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <Link href="/settings/company/create" as="button" class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        {{ $t('settingsCompanyAdd') }}
                    </Link>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" v-if="listdata.data.length > 0">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">ID</th>
                            <th scope="col" class="px-4 py-3" width="30%">{{ $t('companyListName') }}</th>
                            <th scope="col" class="px-4 py-3">{{ $t('companyListDesc') }}</th>
                            <th scope="col" class="px-4 py-3">{{ $t('createdAt') }}</th>
                            <th scope="col" class="px-4 py-3">{{ $t('updatedAt') }}</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">{{ $t('action') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b dark:border-gray-700" v-for="(item, index) in listdata.data" :key="index">
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ item.id }}</th>
                            <td class="px-4 py-3">{{ item.name }}</td>
                            <td class="px-4 py-3">{{ item.description }}</td>
                            <td class="px-4 py-3">{{ item.created_at }}</td>
                            <td class="px-4 py-3">{{ item.updated_at }}</td>
                            <td class="px-4 py-3 flex items-center justify-end">
                                <button 
                                    :id="`company-action-btn-${item.id}`" 
                                    :data-dropdown-toggle="`action-${item.id}-dropdown`" 
                                    class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <div 
                                    :id="`action-${item.id}-dropdown`" 
                                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="apple-imac-27-dropdown-button">
                                        <li> <Link :href="`/settings/company/${item.id}`" class="block text-blue-600 py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $t('show') }}</Link> </li>
                                        <li> <Link :href="`/settings/company/${item.id}/edit`" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $t('edit') }} </Link> </li>
                                    </ul>
                                    <div class="py-1">
                                        <a href="javascript:void(0)" @click="_setSelected(item.id)" class="block py-2 px-4 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ $t('delete') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>                        
                    </tbody>
                </table>
                <div v-else class="md:space-x-4 p-4">
                    <no-data> {{ $t('noData') }} </no-data>
                </div>   
            </div>
            <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="table navigation">
                <pagination :listdata="listdata" v-if="listdata.links.length > 3" />
            </nav>
        </div>
    </div>
  </template>