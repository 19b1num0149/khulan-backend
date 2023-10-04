<script setup>
    import PageTitle from '@/components/PageTitle.vue';
    import { Link, Head } from '@inertiajs/vue3'; 
    import { Tabs, initFlowbite } from 'flowbite';
    import { ref, onMounted } from 'vue';

    const props = defineProps({ 
        data: Object,
        listtypes: Object,
        types: Object,
        categories: Object
    })

    // let _tabs = ref('')

    // const tabOptions = {
    //   defaultTabId: 'people',      
    //   onShow: () => {
    //      // console.log('tab is shown');
    //   }
    // };

    // function movingTab(id) {
    //         _tabs.value.show(id);
    // }

    // function _typeName(value) {
    //     let name = '';
    //     props.types.map((item) => {
    //         item.id == value
    //         ? name = item.name
    //         : null
    //     })
    //     return name
    // }

    onMounted(() => {
        initFlowbite();

        // const tabElements = [
        //     {
        //         id: 'people',
        //         triggerEl: document.querySelector('#people-tab'),
        //         targetEl: document.querySelector('#people-tab-content')
        //     },
        //     {
        //         id: 'activity',
        //         triggerEl: document.querySelector('#activity-tab'),
        //         targetEl: document.querySelector('#activity-tab-content')
        //     }
        // ];
        // _tabs.value = new Tabs(tabElements, tabOptions);
    })
    function printQR() {
        print();
    }

</script>
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .print-container, .print-container * {
            visibility: visible;
        }

        .print-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .print-container img {
            transform: scale(8);
        }
    }
</style>
<template>

    <div>
        <Head :title="data?.name" />

        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            
            <page-title 
                :title="data?.name"
                :subtitle="''"></page-title>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4">

                <div class="flex">
                    <!-- <div class="flex-1">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">                          
                            <Link 
                            as="button"
                            href="/company/temple/data"
                            class="px-2 py-2 bg-white border border-transparent focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-lg dark:bg-gray-800 dark:border-transparent dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                            </svg>                       
                            </Link>
                            <span class="ml-4">{{ item.name }}</span>
                            <button class="float-right mb-3 flex items-center justify-center text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
                                @click="printQR()">
                                {{ $t ('print') }}
                            </button>
                        </h5>
                        <p class="mb-4 font-normal text-sm text-gray-700 dark:text-gray-400 mr-4">
                            {{ item.description }}
                        </p>
                        <div class="flex mb-4 md:flex-row sm:flex-col">
                            <div class="flex-auto text-xs font-semibold">
                            <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('templeItemCode') }}:</span>
                            {{ item.code }}
                            </div>
                            <div class="flex-auto text-xs font-semibold">
                            <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('templeItemType') }}:</span>
                            {{ _typeName(item.type) }}
                            </div>
                            <div class="flex-auto text-xs font-semibold">
                            <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('templeItemCategory') }}:</span>
                            {{ item.categories.name }}
                            </div>
                            <div class="flex-auto text-xs font-semibold">
                            <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('templeItemMadeAt') }}:</span>
                            {{ item.made_at }}
                            </div>
                            <div class="flex-auto text-xs print-container">
                            <img class="w-20 h-20" :src="`data:image/jpeg;${item.qrcode}`" :alt="item.name" v-if="item.qrcode" />
                            </div>
                        </div>  
                        <div class="flex mb-4 md:flex-row sm:flex-col">
                            <div class="flex-auto text-xs font-semibold">
                            <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('templeItemCompanyBuilt') }}:</span>
                            {{ item.company_built }}
                            </div>
                            <div class="flex-auto text-xs font-semibold">
                            <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('templeItemCompanyBuiltBasement') }}:</span>
                            {{ item.company_built_basement }}
                            </div>
                            <div class="flex-auto text-xs font-semibold">
                            <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('templeItemDesignDesc') }}:</span>
                            {{ item.company_designed }}
                            </div>
                        </div>
                    </div>  -->
                    {{ data }}
                </div>

            </div>

            <!-- Tabs Section -->
            <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <!-- Tabs -->
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tabs" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button  
                                    id="people-tab" 
                                    type="button" 
                                    role="tab"
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                    @click="movingTab('people')"
                                    aria-controls="people-tab-content" 
                                    aria-selected="false"> {{ $t('groupMember') }} </button>
                        </li>
                        <li role="presentation">
                            <button 
                                    id="activity-tab" 
                                    type="button" 
                                    role="tab"
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                    @click="movingTab('activity')"
                                    aria-controls="activity-tab-content" 
                                    aria-selected="false"> {{ $t('templeTabActivity') }} </button>
                        </li>                    
                    </ul>
                </div>
                <!-- Tab container -->
                <!-- <div id="tabsContents">

                    <div class="hidden" id="people-tab-content" role="tabpanel" aria-labelledby="people-tab">
                        <people
                            key="people"
                            :itemid="item?.id"
                            :listtypes="listtypes" />
                    </div>

                    <div class="hidden" id="activity-tab-content" role="tabpanel" aria-labelledby="activity-tab">
                        <activity 
                            key="activity"
                            :itemid="item?.id" /> 
                    </div>

                </div> -->
                
            </div>
        </div>
    </div>

</template>