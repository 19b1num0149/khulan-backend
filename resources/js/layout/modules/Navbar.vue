<script setup>
    import { computed, onMounted } from 'vue'
    import { usePage, Link } from '@inertiajs/vue3'    
    
    const page = usePage()
    const user = computed(() => page.props.auth.user)
    const appname = computed(() => page.props.appname)

</script>
<template>
    <nav class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex justify-start items-center">
            <button
                data-drawer-target="drawer-navigation"
                data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    <svg
                        aria-hidden="true"
                        class="hidden w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                        >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                <span class="sr-only">{{ $t('toggleSidebar') }}</span>
            </button>
            <Link href="/dashboard" class="flex items-center justify-between mr-4">
                <!-- <img
                    src="https://flowbite.s3.amazonaws.com/logo.svg"
                    class="mr-3 h-8"
                    alt="Flowbite Logo"
                /> -->
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                    {{ appname }} <span v-if="user.company_id">- {{ user.company.name }}</span>
                </span>
            </Link>
            <form class="hidden md:block md:pl-2">
                <label for="topbar-search" class="sr-only">{{ $t('navSearch') }}</label>
                <div class="relative md:w-64 md:w-96">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg
                            class="w-5 h-5 text-gray-500 dark:text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="topbar-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        :placeholder="$t('navSearch')"/>
                </div>
            </form>
        </div>
        <div class="flex items-center lg:order-2">
            <button
                type="button"
                data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-1 text-gray-500 rounded-lg md:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                <span class="sr-only">Toggle search</span>
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"></path>
                </svg>
            </button>
            
            <!-- Apps -->
            <button
                v-if="user.type=='admin'"
                type="button"
                data-dropdown-toggle="apps-dropdown"
                class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                <span class="sr-only">Apps</span>
                <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div
                v-if="user.type=='admin'"
                class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
                id="apps-dropdown">

                <div class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300"> Apps </div>
                    <div class="grid grid-cols-3 gap-4 p-4">
                    <!-- Companies -->
                    <Link href="/settings/company" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" 
                            aria-hidden="true" 
                            class="mx-auto mb-1 w-8 h-8 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                            fill="currentColor"
                            viewBox="0 -960 960 960">
                            <path d="M160-740v-60h642v60H160Zm5 580v-258h-49v-60l44-202h641l44 202v60h-49v258h-60v-258H547v258H165Zm60-60h262v-198H225v198Zm-50-258h611-611Zm0 0h611l-31-142H206l-31 142Z"/>
                        </svg>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $t('company') }}</div>
                    </Link>
                    <Link href="/settings/product" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 -960 960 960" 
                            aria-hidden="true" 
                            class="mx-auto mb-1 w-8 h-8 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                            fill="currentColor">
                            <path d="M206-120q-20 0-36.5-12T148-164L38-562q-4-14 4.826-26Q51.65-600 67-600h202l185-270q5-6 11-9.5t14-3.5q8 0 14 3.5t11 9.5l184 270h206q15.349 0 24.174 12Q927-576 923-562L812-164q-5 20-21.5 32T754-120H206Zm0-60h548l101-360H106l100 360Zm274.177-120Q505-300 522.5-317.677t17.5-42.5Q540-385 522.323-402.5t-42.5-17.5Q455-420 437.5-402.323t-17.5 42.5Q420-335 437.677-317.5t42.5 17.5ZM342-600h273L479-800 342-600Zm139 240Z"/>
                        </svg>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $t('product') }}
                        </div>
                    </Link>
                    <Link href="/settings/country" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 -960 960 960"
                            aria-hidden="true" 
                            class="mx-auto mb-1 w-8 h-8 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                            fill="currentColor">
                            <path d="M200-120v-680h343l19 86h238v370H544l-18.933-85H260v309h-60Zm300-452Zm95 168h145v-250H511l-19-86H260v251h316l19 85Z"/>
                        </svg>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $t('country') }}
                        </div>
                    </Link>
                    <Link href="/settings/region" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 -960 960 960"
                            aria-hidden="true" 
                            class="mx-auto mb-1 w-8 h-8 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                            fill="currentColor">
                            <path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-60-30-30q-7-7-9.5-14.427t-2.5-15.914V-438q-35.062 0-60.031-24.675T353-522v-42.667L220-698q-38 45-59 100.151-21 55.152-21 117.728Q140-338 238.812-239 337.625-140 480-140Zm42-2q127-17 212.5-112T820-479.774q0-141.407-99.408-240.816Q621.184-820 479.78-820q-46.78 0-89.28 12T310-774v82h150.875q19.125 0 36.625 8t29.5 24l59.379 74H650q17 0 29.5 12.5T692-544v45.134q0 9.672-2.5 18.269Q687-472 682-464L522-224.891V-142Z"/>
                        </svg>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $t('region') }}
                        </div>
                    </Link>
                    <Link href="/settings/city" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 -960 960 960"
                            aria-hidden="true" 
                            class="mx-auto mb-1 w-8 h-8 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                            fill="currentColor">
                            <path d="M120-120v-558h247v-92l113-110 113 110v258h247v392H120Zm60-60h106v-106H180v106Zm0-166h106v-106H180v106Zm0-166h106v-106H180v106Zm247 332h106v-106H427v106Zm0-166h106v-106H427v106Zm0-166h106v-106H427v106Zm0-166h106v-106H427v106Zm247 498h106v-106H674v106Zm0-166h106v-106H674v106Z"/>
                        </svg>
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $t('city') }}
                        </div>
                    </Link>
                </div>
            </div>

            <!-- User Profile DropDown -->
            <button
                type="button"
                class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                id="user-menu-button"
                aria-expanded="false"
                data-dropdown-toggle="user-dropdown">
                <span class="sr-only">{{ $t('openUserMenu') }}</span>
                <img class="w-8 h-8 rounded-full"
                     src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                     alt="user photo"/>
            </button>            
            <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
                 id="user-dropdown">
                <div class="py-3 px-4">
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ user.name }}</span>
                    <span class="block text-sm text-gray-900 truncate dark:text-white">{{ user.email }}</span>
                </div>
                <ul class="py-1 text-gray-700 dark:text-gray-300"
                    aria-labelledby="dropdown">
                    <li>
                        <Link :href="`/settings/profile/${user.id}`"
                           class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                           {{ $t('profile') }}
                        </Link>
                    </li>
                    <li>
                        <a  href="#"
                            class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                            {{ $t('accountSettings') }}
                        </a>
                    </li>
                </ul>
                
                <ul class="py-1 text-gray-700 dark:text-gray-300"
                    aria-labelledby="dropdown">
                    <li>
                        <Link 
                            href="/logout"                            
                            method="post"
                            class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            {{ $t('signOut') }}
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
</template>