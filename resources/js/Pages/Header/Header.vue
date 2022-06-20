<template>
    <div>
        <div class="bg-slate-800 flex justify-between px-2 border-b border-slate-700">
            <div class="flex space-x-3">
                <div class="w-6 flex items-center">
                    <img class="cursor-pointer" @click="showMenu = !showMenu" src="../../../img/burgerMenu.png" alt="Menu">
                </div>
                <div class="w-12 flex items-center">
                    <inertial-link :href="route('home')">
                        <img class="cursor-pointer" src="../../../img/youtubeLogo.png" alt="Logo YouTube">
                    </inertial-link>
                </div>
            </div>
            <div class="invisible  sm:visible sm:flex sm:items-center">
                <input class="sm:h-6 sm:bg-slate-900 sm:text-white placeholder:text-slate-600 sm:rounded-md" type="text" placeholder="Search...">
            </div>
            <div>
                <img src="../../../img/profile.png" alt="Profile">
            </div>
        </div>
        <Menu v-show="showMenu"></Menu>
    </div>
</template>

<script>
import Menu from './Menu.vue';

export default {
    components: {
        Menu,
    },
    data() {
        return {
            showMenu: false,
        }
    },
}

</script>