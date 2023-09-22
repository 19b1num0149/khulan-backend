<script setup>
    import useEventsBus from '../eventBus';
    import { ref, watch, onMounted } from 'vue';
    import { Modal } from 'flowbite';

    const { emit, bus } = useEventsBus()  // Global Emit

    const options = {        
        closable: false,
        backdrop: 'dynamic',
        backdropClasses: 'bg-gray-900 bg-opacity-60 dark:bg-opacity-80 fixed inset-0 z-40',
        onHide: () => {
            emit('confirm-modal-closed')
        },
        onShow: () => {
            // console.log('modal is shown');
        }
    };

    let load = ref(false)
    let confirmationModal = ref('')
    let _suffix = ref('')

    function confirm() {
        load.value = true;
        if(_suffix.value !== '' && _suffix.value.length > 0) {
            emit(`confirm-delete-${_suffix.value}`)
        }
        else {
            emit('confirm-delete')
        }
    }

    function close() {
        confirmationModal.value.hide()
    }

    // Listening Event for confirmation.
    watch(() => bus.value.get('confirm-row-deleted'), () => {
        load.value = false
        _suffix.value = '';
        close()
    })

    // Modal Open
    watch(() => bus.value.get('confirm-open'), (value) => {
        _suffix.value = value
        confirmationModal.value.show()
    })

    // Lifecycle methods
    onMounted(() => {
        let htmlModal = document.getElementById('confirmation-modal')
        confirmationModal.value = new Modal(htmlModal, options)
    })

</script>
<template>
   <div 
      id="confirmation-modal" 
      data-modal-backdrop="static"
      aria-hidden="true"
      tabindex="-1"
      class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      
      <div class="relative w-full max-w-md max-h-full">
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <button 
                type="button" 
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"                
                @click="close"
                :disabled="load">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                  </svg>
                  <span class="sr-only">{{ $t('close') }}</span>
              </button>
              <div class="p-6 text-center">
                  <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                  </svg>
                  <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">{{ $t('confirmDelete') }}</h3>
                  <button 
                    @click="confirm" 
                    type="button" 
                    class="text-white text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 font-medium rounded-lg"
                    :class="[{ 'bg-red-400 dark:bg-red-500 cursor-not-allowed text-sm': load},
                             { 'bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800': !load}]"
                    :disabled="load">
                      {{ $t('confirmBtn') }}
                  </button>
                  <!-- data-modal-hide="confirmation-modal" -->
                  <button :disabled="load" @click="close" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ $t('cancelBtn') }}</button>
              </div>
          </div>
      </div>
      
  </div>
</template>