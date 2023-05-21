<template>
    <div class="flex justify-center bg-principal">
        <div class="pt-20 flex justify-between text-white sm:space-x-2 md:space-x-4">
            <Link :href="route('home')">
                <button :class="{'bg-white': all, 'text-black': all, 'bg-secondary': !all}" class="rounded-[10px] py-1 px-2">
                    All
                </button>
            </Link>
            <Link :href="route('gaming')">
                <button :class="{'bg-white': gaming, 'text-black': gaming, 'bg-secondary': !gaming}" class="rounded-[10px] py-1 px-2">
                    Gaming
                </button>
            </Link>
            <Link :href="route('music')">
                <button :class="{'bg-white': music, 'text-black': music, 'bg-secondary': !music}" class="rounded-[10px] py-1 px-2">
                    Music
                </button>
            </Link>
            <Link :href="route('news')">
                <button :class="{'bg-white': news, 'text-black': news, 'bg-secondary': !news}" class="rounded-[10px] py-1 px-2">
                    News
                </button>
            </Link>
            <Link :href="route('sports')">
                <button :class="{'bg-white': sports, 'text-black': sports, 'bg-secondary': !sports}" class="rounded-[10px] py-1 px-2">
                    Sports
                </button>
            </Link>
            <Link :href="route('learning')">
                <button :class="{'bg-white': learning, 'text-black': learning, 'bg-secondary': !learning}" class="rounded-[10px] py-1 px-2">
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
    },
    props: {
        all: Boolean,
        gaming: Boolean,
        music: Boolean,
        news: Boolean,
        sports: Boolean,
        learning: Boolean,
    }
}
</script>