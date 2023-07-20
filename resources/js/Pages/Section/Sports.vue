<template>
    <div class="bg-principal">
        <Header 
            @getQuery="querySon"
            @getShowNavBar="getShowNavBar"
        >
        </Header>

        <NavBar 
            :homeView="homeView"
            :showNavBar="showNavBar"
        />

        <div class="md:pl-16">
            <NavSection :sports="sports"/>
    
            <!-- Videos -->
            <HomeVideos :videos="videos"/>
        </div>
    </div>
</template>

<script>
import Header from '../Header/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';
import NavSection from './NavSection.vue';
import NavBar from './NavBar.vue';
import HomeVideos from '../Components/HomeVideos.vue';

export default {
    components: {
        Header,
        Link,
        NavSection,
        NavBar,
        HomeVideos
    },
    data() {
        return {
            q: null,
            sports: true,
            showNavBar: true
        }
    },
    props: {
        videos: {
            type: Array,
        }
    },
    methods: {
        querySon(value) {
            this.q = value;
        },
        getShowNavBar(data) {
            this.showNavBar = data;
            console.log(this.showNavBar);
        }
    },
    watch: {
        q: function (q) {
            this.$inertia.get(this.route('home', {q: q}), {}, {preserveState: true})
        }
    },
}
</script>