<template>
    <a :href="route('login.google')">
        <div class="border border-gray-300 rounded-md p-2 flex hover:bg-gray-100 px-4">
            <img src="../../../../img/google-login.png" alt="Google Login">
            <span class="ml-3">Login with Google</span>
        </div>
    </a>
</template>

<script>
export default {
    //
}
</script>