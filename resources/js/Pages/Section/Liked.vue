<template>
    <div class="bg-principal">
        <Header 
            @getQuery="querySon"
        >
        </Header>
    
        <NavBar :likesView="likesView"/>

        <div class="text-white pt-20 flex justify-center">
            <div>
                <div>
                    <h1 class="text-xl">Liked Videos</h1>
                </div>
            
                <div class="pb-[200rem] pt-4">
                    <div v-for="like in liked" :key="like.id">
                        <Link :href="route('videos.show', like.video.id)">
                            <div class="border border-slate-500 p-2 hover:bg-slate-800">
                                <img 
                                    class="h-48 w-full sm:h-40 sm:w-72"
                                    :src="'storage/' + like.video.image" 
                                    alt="Video image">
                                <h3 class="w-72">
                                    {{ like.video.title }}
                                </h3>
                            </div>
                        </Link>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
import Header from '../Header/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';
import NavBar from './NavBar.vue';

export default {
    components: {
        Header,
        Link,
        NavBar
    },
    props: {
        liked: Array,
    },
    methods: {
        querySon(value) {
            this.q = value;
        }
    },
    watch: {
        q: function (q) {
            this.$inertia.get(this.route('home', {q: q}), {}, {preserveState: true})
        }
    },
    data() {
        return {
            likesView: true
        }
    }
}
</script>