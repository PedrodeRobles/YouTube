<template>
    <div class="fixed w-full">
        <div class="bg-principal flex justify-between px-2 py-1">
            <div class="flex">
                <div class="w-6 flex items-center md:ml-4">
                    <img class="cursor-pointer" @click="toggleNavBar()" src="../../../img/burgerMenu.png" alt="Menu">
                </div>
                <div class="w-12 flex items-center ml-5">
                    <Link :href="route('home')">
                        <img class="cursor-pointer" src="../../../img/youtubeLogo.png" alt="Logo YouTube">
                    </Link>
                </div>
            </div>
            <div class="invisible  sm:visible sm:flex sm:items-center">
                <input v-model="query" class="sm:h-8 sm:bg-[#121212] sm:text-white placeholder:text-slate-600 w-0 sm:w-52 lg:w-96 rounded-l-full" type="text" placeholder="Search...">
                <button @click="sendToFather()" class="border-2 border-slate-600 bg-slate-secondary p-1 rounded-r-full sm:px-3">
                    <img class="w-5" src="../../../img/searchIcon.png" alt="Search">
                </button>
            </div>
            <div class="flex items-center mr-4">
                <!-- Verify if the user has been authenticated -->
                <div v-if="$page.props.checkAuth">
                    <img
                        v-if="$page.props.userAuthImg[0].image == null" 
                        src="../../../img/profile.png" 
                        @click="showOptions = !showOptions"
                        alt="Profile"
                        class="cursor-pointer"
                    >
                    <img 
                        v-else
                        :src="$page.props.userAuthImg[0].profile_image" 
                        @click="showOptions = !showOptions"
                        alt="Profile"
                        class="w-[50px] h-[50px] rounded-full cursor-pointer"
                    >
                    <div class="flex justify-center">
                        <UserOptions 
                            v-show="showOptions"
                            :userLoggedName="$page.props.userLoggedName"
                            :userLoggedId="$page.props.userLoggedId"
                            :showOptions="showOptions"
                        ></UserOptions>
                    </div>
                </div>
                <div v-else class="text-white space-x-2">
                    <Link :href="route('login')">Log in</Link>
                    <Link :href="route('register')">Register</Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import UserOptions from './UserOptions.vue'

export default {
    components: {
        Link,
        UserOptions,
    },
    data() {
        return {
            showNavBar: true,
            query: null,
            showOptions: false,
        }
    },
    methods: {
        sendToFather() {
            this.$emit('getQuery', this.query);
            this.toggleNavBar()
        },
        toggleNavBar() {
            this.showNavBar = !this.showNavBar
            this.$emit('getShowNavBar', this.showNavBar);
        }
    },
}

</script>