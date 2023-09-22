<script setup>
    import PageTitle from '@/components/PageTitle.vue'
    import { useForm, Link, Head } from '@inertiajs/vue3'
    import { ref } from 'vue'

    let regions = ref([])
    let cities = ref([])

    const props = defineProps({ 
        flash: Object,
        categories: Object,
        types: Object,
        jobtypes: Object,
        countries: Object,
        customers: Object
    })

    const form = useForm({
        name: '',
        description: '',
        category: '',
        type: '',
        jobtype: '',
        duration: '',
        country: '',
        region: '',
        city: '',
        salary: '',
        customer: ''
    })

    async function onChangeCountry() {
      try {
        let responseData = await axios({
            method: 'get',
            url: `/company/hr/vacancy/get/regions?country=${form.country}`
        })
        .then((response) => { return response; })
        .catch((error) => { return error.response })

        const { status, data } = responseData;
        switch(status) {
            case 200:                
                regions.value = data.regions
                break;
            case 401: 
                router.get('/');
                break;
        }
      }
      catch(e) {
         console.log(e)
      }
    }

    async function onChangeRegion() {
      try {
        let responseData = await axios({
            method: 'get',
            url: `/company/hr/vacancy/get/cities?region=${form.region}`
        })
        .then((response) => { return response; })
        .catch((error) => { return error.response })

        const { status, data } = responseData;
        switch(status) {
            case 200:                
                cities.value = data.cities
                break;
            case 401: 
                router.get('/');
                break;
        }
      }
      catch(e) {
         console.log(e)
      }
    }

    function reset() {
        form.reset('name')
        form.reset('description')
        form.reset('category')
        form.reset('type')
        form.reset('jobtype')
        form.reset('duration')
        form.reset('country')
        form.reset('region')
        form.reset('city')
        form.reset('salary')
        form.reset('customer')
        regions.value = []
        cities.value = []
    }

    function submit() {
        form.post('/company/hr/vacancy', {
            preserveScroll: true,
            onSuccess: () => reset(),
        })
    }

</script>

<template>

    <div>
        <Head :title="$t('hrVacancyAdd')" />
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <page-title 
                :title="$t('hrVacancy')"
                :subtitle="$t('hrVacancyAdd')"></page-title>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <transition name="fade" mode="out-in" appear>
                    <alert 
                        v-if="flash.success"
                        type="success">{{ flash.success }}</alert>
                </transition> 
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $t('hrVacancyAdd') }}</h5>
                <hr class="mt-4 mb-4">                
                <form @submit.prevent="submit">
                    <!-- body -->
                    <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <!-- First Row -->
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <div>
                                <label for="name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyName') }} *</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    :class="[{ 'border-red-500': form.errors.name }]"
                                    placeholder=""
                                    v-model="form.name" 
                                    autocomplete="off">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.name">{{ form.errors.name }}</p>
                            </div>
                            <div>
                                <label for="salary" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancySalary') }}</label>
                                <input 
                                    type="text" 
                                    id="salary" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    :class="[{ 'border-red-500': form.errors.salary }]"
                                    placeholder=""
                                    v-model="form.salary" 
                                    autocomplete="off">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.salary">{{ form.errors.salary }}</p>
                            </div>
                            <div>
                                <label for="duration" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyDuration') }}</label>
                                <input 
                                    type="text" 
                                    id="duration" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    :class="[{ 'border-red-500': form.errors.duration }]"
                                    placeholder=""
                                    v-model="form.duration" 
                                    autocomplete="off">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.duration">{{ form.errors.duration }}</p>
                            </div>
                            <div>
                                <label for="customer" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyCustomer') }}</label>
                                <select id="customer"                                         
                                        v-model="form.customer"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        :class="[{ 'border-red-500': form.errors.customer }]">
                                   <option value="">{{ $t('pleaseSelect') }}</option>
                                   <option v-for="(item, index) in customers" :key="index" :value="item.id">{{ item.name }}</option>                  
                                </select>               
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.customer">{{ form.errors.customer }}</p>
                            </div>
                        </div>
                        <!-- Second Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="category" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyCategory') }}</label>
                                <select id="category"                                         
                                        v-model="form.category"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        :class="[{ 'border-red-500': form.errors.category }]">
                                   <option value="">{{ $t('pleaseSelect') }}</option>
                                   <option v-for="(item, index) in categories" :key="index" :value="item.id">{{ item.name }}</option>                  
                                </select>               
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.category">{{ form.errors.category }}</p>
                            </div>
                            <div>
                                <label for="type" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyType') }}</label>
                                <select id="type"                                         
                                        v-model="form.type"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        :class="[{ 'border-red-500': form.errors.type }]">
                                   <option value="">{{ $t('pleaseSelect') }}</option>
                                   <option v-for="(item, index) in types" :key="index" :value="item.id">{{ item.name }}</option>                  
                                </select>               
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.type">{{ form.errors.type }}</p>
                            </div>
                            <div>
                                <label for="jobtype" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyJobType') }}</label>
                                <select id="jobtype"                                         
                                        v-model="form.jobtype"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        :class="[{ 'border-red-500': form.errors.jobtype }]">
                                   <option value="">{{ $t('pleaseSelect') }}</option>
                                   <option v-for="(item, index) in jobtypes" :key="index" :value="item.id">{{ item.name }}</option>                  
                                </select>               
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.jobtype">{{ form.errors.jobtype }}</p>
                            </div>
                        </div>
                        <!-- Third Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="country" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyCountry') }}</label>
                                <select id="country"
                                        @change="onChangeCountry"                                      
                                        v-model="form.country"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        :class="[{ 'border-red-500': form.errors.country }]">
                                   <option value="">{{ $t('pleaseSelect') }}</option>
                                   <option v-for="(item, index) in countries" :key="index" :value="item.id">{{ item.name }}</option>                  
                                </select>               
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.country">{{ form.errors.country }}</p>
                            </div>
                            <div>
                                <label for="region" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyRegion') }}</label>
                                <select id="region"
                                        @change="onChangeRegion"
                                        v-model="form.region"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        :class="[{ 'border-red-500': form.errors.region }]">
                                    <option value="">{{ $t('pleaseSelect') }}</option>
                                    <option v-for="(item, index) in regions" :key="index" :value="item.id">{{ item.name }}</option>                  
                                </select>               
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.region">{{ form.errors.region }}</p>
                            </div>
                            <div>
                                <label for="city" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyCity') }}</label>
                                <select id="city"                                         
                                        v-model="form.city"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        :class="[{ 'border-red-500': form.errors.city }]">
                                   <option value="">{{ $t('pleaseSelect') }}</option>
                                   <option v-for="(item, index) in cities" :key="index" :value="item.id">{{ item.name }}</option>                  
                                </select>               
                                <p class="mt-1 text-xs text-red-600 dark:text-red-500" v-if="form.errors.city">{{ form.errors.city }}</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('hrVacancyDescription') }}</label>
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
                        <Link class="py-2.5 px-5 ml-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" href="/company/hr/vacancy">{{ $t('back') }}</Link>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

</template>