<template>
    <div>
        <div class="bg-red-500 pt-12">
            <div class="bg-indigo-600">
                <img class="h-32 sm:h-26 md:h-44 lg:h-60 w-full" src="../../../img/videoImage.png" alt="image">
            </div>
            <div class="flex justify-center">
                <img src="../../../img/profile.png" alt="">
                <p>{{ user }}</p>
            </div>
        </div>
    </div>
</template>

<script>

export default  {
    props: {
        user: String
    },
}

</script>