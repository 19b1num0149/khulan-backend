<script setup>

    import { computed } from 'vue';
    import { Dismiss } from 'flowbite';

    const props = defineProps({ 
        type: String,
        header: String
    })

    const alertype = computed(() => {
        let text = '';
        const { type } = props;
        switch(type) {
            case 'success':
                text = 'text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400'
                break;
            case 'warning':
                text = 'text-yellow-800 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400'
                break;
            case 'info':
                text = 'text-blue-800 bg-blue-50 dark:bg-gray-800 dark:text-blue-400'
                break;
            case 'danger':
                text = 'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400'
                break;
        }
        return text;
    })

    const buttonAlertType = computed(() => {
        let text = '';
        const { type } = props;
        switch(type) {
            case 'success':
                text = 'bg-green-50 text-green-500 hover:bg-green-200 dark:text-green-400'
                break;
            case 'warning':
                text = 'bg-yellow-50 text-yellow-500 hover:bg-yellow-200 dark:text-yellow-400'
                break;
            case 'info':
                text = 'bg-blue-50 text-blue-500 hover:bg-blue-200 dark:text-blue-400'
                break;
            case 'danger':
                text = 'bg-red-50 text-red-500 hover:bg-red-200 dark:text-red-400'
                break;
        }
        return text;
    })

    function hideAlert() {
        // target element that will be dismissed
        const $alert = document.getElementById('alert');
        const dismiss = new Dismiss($alert);
        // hide the target element
        dismiss.hide();
    }

</script>
<template>

    <div 
        id="alert"
        class="flex items-center p-4 mb-4 rounded-lg"
        :class="alertype"
        role="alert">
    
        <span class="sr-only" v-if="header" >{{ header }}</span>
        <div class="ml-3 text-sm font-medium">
            <slot />
        </div>
        <button type="button" 
                class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:hover:bg-gray-700" 
                :class="buttonAlertType"
                aria-label="Close"
                data-dismiss-target="#alert"
                @click="hideAlert">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>

</template>