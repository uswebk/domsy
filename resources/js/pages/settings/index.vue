<template>
    <div class="row justify-content-center">
        <div v-for='mail in mailCategories' :key="mail.id">
            <p>{{ mail.annotation }}</p>
        </div>
    </div>
</template>


<script>
    export default {
        props: {
            mailCategories: {
                type: Object
            },
        },
    }
</script>