<template>
    <div class="bg-slate-800 text-white pt-16 md:pt-0">
        <nav class="md:invisible md:w-0 md:h-0 visible w-screen h-16 bg-slate-800 fixed text-white">
            <div class="flex justify-around items-center">
                <div>
                    <img src="../../../img/home.png" alt="Home" class="w-8 md:w-0">
                    <p class="text-sm">
                        Home
                    </p>
                </div>
                <div>
                    <Link :href="route('liked')">
                        <img src="../../../img/like.png" alt="Liked" class="w-8 md:w-0">
                        <p class="text-sm md:ml-1">
                            Liked
                        </p>
                    </Link>
                </div>
                <div>
                    <Link :href="route('subscriptions')">
                        <img src="../../../img/subscriptions.png" alt="subscriptions" class="w-8 md:w-0">
                        <p class="text-sm md:ml-1">
                            Subs.
                        </p>
                    </Link>
                </div>
            </div>
        </nav>
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