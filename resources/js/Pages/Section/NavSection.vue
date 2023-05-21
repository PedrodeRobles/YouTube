<template>
    <div class="flex justify-center bg-principal">
        <div class="pt-20 flex justify-between text-white sm:space-x-2 md:space-x-4">
            <Link :href="route('home')">
                <button class="bg-white rounded-[15px] py-1 px-2 text-black">
                    All
                </button>
            </Link>
            <Link :href="route('gaming')">
                <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                    Gaming
                </button>
            </Link>
            <Link :href="route('music')">
                <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                    Music
                </button>
            </Link>
            <Link :href="route('news')">
                <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                    News
                </button>
            </Link>
            <Link :href="route('sports')">
                <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                    Sports
                </button>
            </Link>
            <Link :href="route('learning')">
                <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                    Learning
                </button>
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
    
export default {
    components: {
        Link
    }
}
</script>