<template>
    <nav class="invisible w-0 h-0 md:visible md:w-16 md:h-screen bg-principal md:mt-14 md:fixed text-white animate__animated"
        :class="{'animate__fadeInLeft': showNavBar, 'animate__fadeOutLeft': !showNavBar}"
    >
        <div class="flex justify-center md:mt-4">
            <div class="space-y-6">
                <div>
                    <Link :href="route('home')">
                        <div class="hover:bg-secondary sm:p-3 sm:rounded-lg">
                            <img v-if="homeView" src="../../../img/home.png" alt="Home" class="md:ml-2">
                            <img v-else src="../../../img/unHome.png" alt="Home" class="md:ml-2">
                            <p class="text-sm">
                                Home
                            </p>
                        </div>
                    </Link>
                </div>
                <div>
                    <Link :href="route('liked')">
                        <div class="hover:bg-secondary sm:p-3 sm:rounded-lg">
                            <img v-if="likesView" src="../../../img/clickLike.png" alt="Liked" class="md:ml-2">
                            <img v-else src="../../../img/like.png" alt="Liked" class="md:ml-2">
                            <p class="text-sm md:ml-1">
                                Liked
                            </p>
                        </div>
                    </Link>
                </div>
                <div>
                    <Link :href="route('subscriptions')">
                        <div class="hover:bg-secondary sm:p-3 sm:rounded-lg">
                            <img v-if="subsView" src="../../../img/clickSubs.png" alt="subscriptions" class="md:ml-2 md:h-[24px] md:w-[24px]">
                            <img v-else src="../../../img/subscriptions.png" alt="subscriptions" class="md:ml-2 md:h-[24px] md:w-[24px]">
                            <p class="text-sm md:ml-1">
                                Subs.
                            </p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import 'animate.css';

export default {
    components: {
        Link
    },
    props: {
        homeView: Boolean,
        likesView: Boolean,
        subsView: Boolean,
        showNavBar: Boolean,
    }
}
</script>