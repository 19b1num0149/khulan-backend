<script setup>
   import { ref, watch, onMounted, reactive } from 'vue';
   import { initFlowbite, Modal } from 'flowbite';
   import FormModal from '@/components/FormModal.vue';
   import { router } from '@inertiajs/vue3'
   import useEventsBus from '@/eventBus';

   const { emit, bus } = useEventsBus()

   const props = defineProps({ companyid: Number,
                               listproduct: Object });

   const form = reactive({
      id: '',
      companyid: props.companyid,
      product: '',
      started: '',
      ended: '',
      description: ''
   })

   let productsdata = ref([]);
   let loader = ref(false);
   let frmModal = ref(''); // Instance of Modal
   let frmType = ref('');
   let frmLoader = ref(false);
   let formErrors = ref({});
   let formSuccessMessage = ref('');
   let _deleteSuccessMessage = ref('');
   let _deleteId = ref('');

   async function getProductsData() {
      try {
         loader.value = true;
         let responseData = await axios({
            method: 'get',
            url: `/settings/company/${props.companyid}/products`
         }).then((response) => {
            return response;
         }).catch((error) => {
            return error.response
         })
         const { status, data } = responseData;
         switch(status) {
            case 200: 
               const { products } = data;
               productsdata.value = products;
               break;
            case 401: 
               router.get('/');
               break;
         }
         loader.value = false;
      }
      catch(e) {
         console.log(e)
      }
   }

   async function storeOrUpdate() {
      try {
         if(frmType.value !== '') {

            frmLoader.value = true;

            let method = 'post';
            let url = `/settings/company/${props.companyid}/products`;
            if(frmType.value == 'edit') {
               method = 'put'
               url = `/settings/company/${props.companyid}/products/${form.id}`;
            }

            let responseData = await axios({
               method: method,
               url: url,
               data: form
            }).then((response) => {
               return response;
            }).catch((error) => {
               return error.response;
            })
            const { status, data } = responseData;
            
            switch(status) {
               case 200: 
                  formSuccessMessage.value = data.success;                  
                  frmType.value !== 'edit' ? resetForm() : null;
                  getProductsData();                  
                  break;
               case 422:
                  formErrors.value = data.errors;
                  break;
               case 401: 
                  router.get('/');
                  break;
            }

            frmLoader.value = false;
         }
         return null;         
      }
      catch(e) {
         console.log(e);
      }
   }

   async function getProductData() {
      try {
         frmLoader.value = true;
         let responseData = await axios({
            method: 'get',
            url: `/settings/company/${props.companyid}/products/${form.id}/edit`
         }).then((response) => {
            return response;
         }).catch((error) => {
            return error.response
         })
         const { status, data } = responseData;
         switch(status) {
            case 200:                
               const { product_id, started_at, ended_at, description } = data.product;
               form.product = product_id;
               form.started = started_at;
               form.ended = ended_at;
               form.description = description;
               break;
            case 401: 
               router.get('/');
               break;
         }

         frmLoader.value = false;
      }
      catch(e) {
         console.log(e)
      }
   }

   async function confirmDelete() {
      try {
         let responseData = await axios({
               method: 'POST',
               url: `/settings/company/${props.companyid}/products/${_deleteId.value}`,
               data: {
                  _method: 'DELETE'
               }
            }).then((response) => {
               return response;
            }).catch((error) => {
               return error.response;
            })
         const { status, data } = responseData;
         switch(status) {
            case 200:
               emit('confirm-row-deleted'); 
               _deleteSuccessMessage.value = data.success;
               getProductsData();               
               break;
            case 401: 
               router.get('/');
               break;
         }
      }
      catch(e) {
         console.log(e);
      }
   }

   function _setSelected(id) {
      _deleteId.value = id;
      emit('confirm-open', 'company-products'); // if confirms only company products component listen it
   }

   function resetForm() {
      form.id = '';      
      form.product = '';
      form.started = '';
      form.ended = '';
      form.description = '';
      // reseting Errors
      formErrors.value = {}
   }

   // Listening Event for confirmation.
   watch(() => bus.value.get('confirm-delete-company-products'), () => {
      confirmDelete()
   })

   watch(() => bus.value.get('confirm-modal-closed'), () => {
      _deleteId.value = '';
   })

   // Lifecycle Methods
   onMounted(() => {
      initFlowbite();      
      frmModal.value = new Modal(document.getElementById('form-modal_products'), modalOptions) // Assigning Instanse 
      getProductsData();
   })

   // Modal options and functions
   // #####################################################################################

   const modalOptions = {
      backdrop: 'dynamic',
      backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
      closable: false,
   }

   function openModal(type, id) {
      frmType.value = type;
      form.id = id;
      if(type == 'edit') {
         getProductData();
      }
      frmModal.value.show();
   }

   function closeModal() {
      frmType.value = '';
      resetForm();
      frmModal.value.hide();
   }

</script>
<template>
   <div>
      <!-- Form create & Edit -->
      <form-modal 
         @close="closeModal"
         suffix="_products"
         :header="frmType == 'edit' ? $t('settingsCompanyProductEdit') : $t('settingsCompanyProductAdd')">
         <transition name="fade" mode="out-in" appear>
            <alert 
                v-if="formSuccessMessage"
                type="success">{{ formSuccessMessage }}</alert>
         </transition> 
         <form class="space-y-3" @submit.prevent="storeOrUpdate">
            <div>
               <label for="product" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('productCompany') }}</label>
               <select id="product" 
                       v-model="form.product"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       :class="[{ 'border-red-500': formErrors.product }]">
                  <option value="">{{ $t('pleaseSelect') }}</option>
                  <option v-for="(item, index) in listproduct" :key="index" :value="item.id">{{ item.name }}</option>                  
               </select>               
               <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="formErrors.product">{{ formErrors.product[0] }}</p>
            </div>
            <div>
               <label for="started" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('productCompanyStart') }}</label>
               <input type="date"                      
                      ref="startedDatepicker"
                      v-model="form.started"
                      id="started"
                      autocomplete="off"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                      :class="[{ 'border-red-500': formErrors.started }]"
                      :placeholder="$t('selectDate')" />               
               <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="formErrors.started">{{ formErrors.started[0] }}</p>
            </div>
            <div>
               <label for="ended" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('productCompanyEnd') }}</label>
               <input type="date"                      
                      v-model="form.ended" 
                      id="ended"
                      autocomplete="off"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                      :class="[{ 'border-red-500': formErrors.ended }]"
                      :placeholder="$t('selectDate')" /> 
               <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="formErrors.ended">{{ formErrors.ended[0] }}</p>              
            </div>
            <div>
               <label for="description" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('productCompanyDescription') }}</label>
               <textarea v-model="form.description" id="description" rows="2" class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>              
            </div>
            <div class="pt-3">
               <button 
                  type="submit"
                  :disabled="frmLoader"
                  class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  {{ $t('save') }}
               </button>
            </div>

            <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2" v-if="frmLoader">
               <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
               <span class="sr-only">Loading...</span>
            </div>
        </form>
      </form-modal>

      <!-- Table List -->
      <transition name="fade" mode="out-in" appear>
         <Loader v-if="loader" key="loader" />
         <div v-else key="listdata" class="overflow-x-auto">
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
               <!-- Alert message -->
               <transition name="fade" mode="out-in" appear>
                  <alert 
                      v-if="_deleteSuccessMessage"
                      type="success">{{ _deleteSuccessMessage }}</alert>
               </transition>

               <div class="flex items-center justify-between mb-4">
                  <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ $t('companyLinkedProducts') }}</h5>
                  <button
                     @click="openModal('create', '')"
                     type="button" 
                     class="mb-3 flex items-center justify-center text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                     <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                     </svg>
                     {{ $t('settingsCompanyProductAdd') }}
                  </button>
               </div>
               <div class="flow-root" v-if="productsdata.length > 0">
                  <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                     <li class="py-3 sm:py-4" 
                           v-for="(item, index) in productsdata"
                           :key="index">
                           <div class="flex items-center space-x-4">                                    
                              <div class="flex-1 min-w-0">
                                 <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ item.product.name }}
                                 </p>
                                 <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ item.product.description }}
                                 </p>
                                 <p class="text-xs text-gray-400 truncate dark:text-gray-200">
                                    Эхэлсэн: {{ item.started_at }}
                                 </p>
                              </div>
                              <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                 <button 
                                    @click="openModal('edit', item.id)" 
                                    type="button" 
                                    class="px-2 py-1.5 text-xs text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-center mr-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">{{ $t('edit') }}</button>
                                 <button
                                    @click="_setSelected(item.id)"
                                    type="button" 
                                    class="px-2 py-1.5 text-xs text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">{{ $t('delete') }}</button>
                              </div>
                           </div>
                     </li>                           
                  </ul>
               </div>
               <div class="flow-root" v-else>
                  <no-data> {{ $t('noData') }} </no-data>
               </div>
            </div> 
         </div>
      </transition>
   </div>
</template>