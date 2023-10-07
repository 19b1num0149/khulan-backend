<script setup>
   import PageTitle from '@/components/PageTitle.vue';
   import { Link, Head } from '@inertiajs/vue3'
   import { Tabs, initFlowbite } from 'flowbite';
   import { ref, onMounted } from 'vue';
   import users from './modules/users.vue';
   import products from './modules/products.vue';

   const props = defineProps({ company: Object,
                               listproduct: Object,
                               flash: Object });

   let _profTabs = ref('')

   // options with default values
   const tabOptions = {
      defaultTabId: 'products',
      // activeClasses: 'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
      // inactiveClasses: 'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
      onShow: () => {
         // console.log('tab is shown');
      }
   };

   function movingTab(id) {
      _profTabs.value.show(id);
   }

   onMounted(() => {
      initFlowbite();

      const tabElements = [
         {
            id: 'products',
            triggerEl: document.querySelector('#products-tab'),
            targetEl: document.querySelector('#products-tab-content')
         },
         {
            id: 'users',
            triggerEl: document.querySelector('#users-tab'),
            targetEl: document.querySelector('#users-tab-content')
         }
      ];
      _profTabs.value = new Tabs(tabElements, tabOptions);
   })

</script>

<template>
   <div>
      <Head :title="company.name" />
      <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
         <page-title 
                :title="$t('settingsCompany')"
                :subtitle="company.name"></page-title>
         <!-- Company profile -->
         <div class="mb-4">
            <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
               
               <div class="flex">
                  <div class="flex-1">
                     <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">                          
                        <Link 
                           as="button"
                           href="/settings/company"
                           class="px-2 py-2 bg-white border border-transparent focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-lg dark:bg-gray-800 dark:border-transparent dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                           <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                           </svg>                       
                        </Link>
                        <span class="ml-4">{{ company.name }}</span>
                     </h5>
                     <p class="mb-4 font-normal text-sm text-gray-700 dark:text-gray-400 mr-4">
                        {{ company.description }}
                     </p>
                     <div class="flex mb-4 md:flex-row sm:flex-col">
                        <div class="flex-auto text-xs font-semibold">
                           <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('companyListPhone') }}:</span>
                           {{ company.phone }}
                        </div>
                        <div class="flex-auto text-xs font-semibold">
                           <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('companyListEmail') }}:</span>
                           {{ company.email }}
                        </div>
                        <div class="flex-auto text-xs font-semibold">
                           <span class="text-gray-500 text-sm dark:text-gray-400 font-normal">{{ $t('companyListAddress') }}:</span>
                           {{ company.address }}
                        </div>
                     </div>                     
                  </div>
                  <!-- Drop down -->
                  <div class="justify-end">
                     <div>
                        <button 
                           id="dropdownCompanyButton" 
                           data-dropdown-toggle="dropdownCompanyProfile" 
                           class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" 
                           type="button">
                           <span class="sr-only">Open dropdown</span>
                           <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                           </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div 
                           id="dropdownCompanyProfile" 
                           class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700">
                           <ul class="py-2" aria-labelledby="dropdownCompanyButton">
                              <li>
                                 <Link 
                                    :href="`/settings/company/${company.id}/edit`" 
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    {{ $t('edit') }}
                                 </Link>
                              </li>                            
                              <li>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"> {{ $t('delete') }} </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>


               
            </div>
         </div>
         <!-- Tabs Section -->
         <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <!-- Tabs -->
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
               <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="profileTabs" role="tablist">
                  <li class="mr-2" role="presentation">
                     <button  
                             id="products-tab" 
                             type="button" 
                             role="tab"
                             class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                             @click="movingTab('products')"
                             aria-controls="products-tab-content" 
                             aria-selected="false"> {{ $t('companyTabProduct') }} </button>
                  </li>
                  <li role="presentation">
                     <button 
                             id="users-tab" 
                             type="button" 
                             role="tab"
                             class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                             @click="movingTab('users')"
                             aria-controls="users-tab-content" 
                             aria-selected="false"> {{ $t('companyTabUser') }} </button>
                  </li>                    
               </ul>
            </div>
            <!-- Tab container -->
            <div id="profileTabsContents">

               <div class="hidden" id="products-tab-content" role="tabpanel" aria-labelledby="profile-tab">
                  <products
                     key="products"
                     :companyid="company.id"
                     :listproduct="listproduct" />
               </div>

               <div class="hidden" id="users-tab-content" role="tabpanel" aria-labelledby="users-tab">
                  <users 
                     key="users"
                     :companyid="company.id" /> 
               </div>

            </div>
            
         </div>
      </div>
   </div>
</template>