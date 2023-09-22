<script setup>
   import { ref, watch, onMounted, reactive } from 'vue';
   import { initFlowbite, Modal } from 'flowbite';
   import FormModal from '@/components/FormModal.vue';
   import { router } from '@inertiajs/vue3'
   import useEventsBus from '@/eventBus';

   const { emit, bus } = useEventsBus()

   const props = defineProps({ 
        itemid: Number,
   });

   const form = reactive({
      id: '',
      itemid: props.itemid,
      who: '',
      activitydate: '',
      activity: '',
   })

   let activitiesdata = ref([]);
   let loader = ref(false);
   let frmModal = ref(''); // Instance of Modal
   let frmType = ref('');
   let frmLoader = ref(false);
   let formErrors = ref({});
   let formSuccessMessage = ref('');
   let _deleteSuccessMessage = ref('');
   let _deleteId = ref('')

   async function getActivitiesData() {
      try {
         loader.value = true;
         let responseData = await axios({
            method: 'get',
            url: `/company/temple/item/${props.itemid}/activity`
         }).then((response) => {
            return response;
         }).catch((error) => {
            return error.response
         })
         const { status, data } = responseData;
         switch(status) {
            case 200: 
               activitiesdata.value = data.activity;
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
            let url = `/company/temple/item/${props.itemid}/activity`;
            if(frmType.value == 'edit') {
               method = 'put'
               url = `/company/temple/item/${props.itemid}/activity/${form.id}`;
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
                  getActivitiesData();                  
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

   function _setActivityData(item) {
      form.id = item.id
      form.who = item.who
      form.activitydate = item.activitydate
   }

   async function confirmDelete() {
      try {
         let responseData = await axios({
               method: 'POST',
               url: `/company/temple/item/${props.itemid}/activity/${_deleteId.value}`,
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
               getActivitiesData();               
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
      emit('confirm-open', 'activity'); // if confirms only activity component listen it
   }

   function resetForm() {
        form.id = '',
        form.who = '',
        form.activitydate = '',
      // reseting Errors
      formErrors.value = {}
   }

   // Listening Event for confirmation.
   watch(() => bus.value.get('confirm-delete-activity'), () => {
      confirmDelete()
   })

   watch(() => bus.value.get('confirm-modal-closed'), () => {
      _deleteId.value = '';
   })

   // Lifecycle Methods
   onMounted(() => {
      initFlowbite();      
      frmModal.value = new Modal(document.getElementById('form-modal_activity'), modalOptions) // Assigning Instanse 
      getActivitiesData();
   })

   // Modal options and functions
   // #####################################################################################

   const modalOptions = {
      backdrop: 'dynamic',
      backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
      closable: false,
   }

   function openModal(type, item) {
      frmType.value = type;      
      if(type == 'edit') {
        _setActivityData(item)
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
         suffix="_activity"
         :header="frmType == 'edit' ? $t('settingsUserEdit') : $t('templeTabPersonAdd')">
         <transition name="fade" mode="out-in" appear>
            <alert 
                v-if="formSuccessMessage"
                type="success">{{ formSuccessMessage }}</alert>
         </transition> 
         <form class="space-y-3" @submit.prevent="storeOrUpdate">
            <div>
               <label for="who" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('templeTabActivityFrmWho') }}</label>
               <input type="text" 
                      v-model="form.who" 
                      id="who"                       
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                      :class="[{ 'border-red-500': formErrors.who }]" />
               <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="formErrors.who">{{ formErrors.who[0] }}</p>
            </div>
            <div>
               <label for="activitydate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('templeTabActivityFrmDate') }}</label>
               <input type="date" 
                      v-model="form.activitydate" 
                      id="activitydate"                       
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                      :class="[{ 'border-red-500': formErrors.activitydate }]" />
               <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="formErrors.activitydate">{{ formErrors.activitydate[0] }}</p>
            </div>
            <div>
               <label for="activity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('templeTabActivityFrmActivity') }} </label>
               <input type="text" 
                      v-model="form.activity" 
                      id="activity"                       
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                      :class="[{ 'border-red-500': formErrors.activity }]" />
               <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="formErrors.activity">{{ formErrors.activity[0] }}</p>
            </div>
            <br>
            <button 
               type="submit"
               :disabled="frmLoader"
               class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
               {{ $t('save') }}
            </button>

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
            <transition name="fade" mode="out-in" appear>
               <alert 
                   v-if="_deleteSuccessMessage"
                   type="success">{{ _deleteSuccessMessage }}</alert>
            </transition>
            <div class="flex items-center justify-between mb-4">
               <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ $t('templeTabActivityTitle') }}</h5>
               <button
                  @click="openModal('create', '')"
                  type="button" 
                  class="mb-3 flex items-center justify-center text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                  <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                  </svg>
                  {{ $t('templeTabActivityAdd') }} 
               </button>
            </div>
            
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" v-if="activitiesdata.length > 0">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                   <tr>
                       <th scope="col" class="px-4 py-3">ID</th>
                       <th scope="col" class="px-4 py-3">{{ $t('templeTabActivityFrmWho') }}</th>
                       <th scope="col" class="px-4 py-3">{{ $t('templeTabActivityFrmDate') }}</th>
                       <th scope="col" class="px-4 py-3">{{ $t('templeTabActivityFrmActivity') }}</th>
                       <th scope="col" class="px-4 py-3 flex items-center justify-end">
                        {{ $t('action') }}
                       </th>
                   </tr>
               </thead>
               <tbody>
                  <tr class="border-b dark:border-gray-700" v-for="(item, index) in activitiesdata" :key="index">
                     <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ item.id }}</th>
                     <td class="px-4 py-3">{{ item.who }}</td>
                     <td class="px-4 py-3">{{ item.activity_date }}</td>
                     <td class="px-4 py-3">{{ item.activity }}</td>
                     <td class="px-4 py-3 flex items-center justify-end">
                        <button 
                           @click="openModal('edit', item)" 
                           type="button" 
                           class="px-2 py-1.5 text-xs text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-center mr-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">{{ $t('edit') }}</button>
                        <button
                           @click="_setSelected(item.id)"
                           type="button" 
                           class="px-2 py-1.5 text-xs text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">{{ $t('delete') }}</button>
                     </td>
                  </tr>                        
               </tbody>
            </table>
            <div v-else class="md:space-x-4 p-4">
                  <no-data> {{ $t('noData') }} </no-data>
            </div>  
         </div>
      </transition>
   </div>
</template>