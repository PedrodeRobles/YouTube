<template>
    <div class="bg-slate-800 border border-slate-600 text-white fixed mt-1 mr-4">
        <div class="p-2 w-28 space-y-1">
            <div>
                <Link :href="route('userVideos', userLoggedName)">
                    My Channel
                </Link>
            </div>
            <div>
                <Link :href="route('dashboard')">
                    Dashboard
                </Link>
            </div>
            <form @submit.prevent="logout">
                <button>
                    Log Out
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    props: {
        userLoggedName: String
    },
    components: {
        Link
    },
    methods: {
        logout() {
            this.$inertia.post(this.route('logout'), this.form);
        },
    },
}
</script>