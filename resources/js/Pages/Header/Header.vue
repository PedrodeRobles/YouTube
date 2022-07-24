<template>
    <div class="fixed w-full">
        <div class="bg-slate-800 flex justify-between px-2 py-1 border-b border-slate-700">
            <div class="flex">
                <div class="w-6 flex items-center md:ml-4">
                    <img class="cursor-pointer" @click="showMenu = !showMenu" src="../../../img/burgerMenu.png" alt="Menu">
                </div>
                <div class="w-12 flex items-center ml-5">
                    <Link :href="route('home')">
                        <img class="cursor-pointer" src="../../../img/youtubeLogo.png" alt="Logo YouTube">
                    </Link>
                </div>
            </div>
            <div class="invisible  sm:visible sm:flex sm:items-center">
                <input v-model="query" class="sm:h-8 sm:bg-slate-900 sm:text-white placeholder:text-slate-600 w-0 sm:w-52 lg:w-96 " type="text" placeholder="Search...">
                <button @click="sendToFather()" class="border-2 border-slate-600 bg-slate-900 p-1">
                    <img class="w-5" src="../../../img/searchIcon.png" alt="Search">
                </button>
            </div>
            <div class="flex items-center mr-4">
                <div 
                    v-if="userAuth === false"
                    class="text-white space-x-2"
                >
                    <Link :href="route('login')">Log in</Link>
                    <Link :href="route('register')">Register</Link>
                </div>
                <div v-else>
                    <img
                        v-if="userAuthImg[0].image == null" 
                        src="../../../img/profile.png" 
                        @click="showOptions = !showOptions"
                        alt="Profile"
                    >
                    <img 
                        v-else
                        :src="userAuthImg[0].profile_image" 
                        @click="showOptions = !showOptions"
                        alt="Profile"
                        class="w-[50px] h-[50px] rounded-full"
                    >
                    <div class="flex justify-center">
                        <UserOptions 
                            v-show="showOptions"
                            :userLoggedName="userLoggedName"
                            :userLoggedId="userLoggedId"
                        ></UserOptions>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Menu v-show="showMenu"></Menu>
</template>

<script>
import Menu from './Menu.vue';
import { Link } from '@inertiajs/inertia-vue3';
import UserOptions from './UserOptions.vue'

export default {
    components: {
        Menu,
        Link,
        UserOptions,
    },
    props: {
        userAuth: Boolean,
        userLoggedName: String,
        userLoggedId: Number,
        userAuthImg: Array,
    },
    data() {
        return {
            showMenu: false,
            query: null,
            showOptions: false,
        }
    },
    methods: {
        sendToFather() {
            this.$emit('getQuery', this.query);
        },
    },
}

</script>