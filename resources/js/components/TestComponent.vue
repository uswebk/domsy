<template>
    <div>
        <button @click="execute()">Run API</button>
        <div class="">{{ response }}</div>
    </div>
</template>

<script>

export default {
    data () {
        return {
            response: ''
        };
    },
    methods: {
        execute () {
            axios.get('/tmp/api').then((response) => {
                this.response = response.data.test;

            }).catch((error) => {
                console.error(error);
            });
        }
    }
    }
</script>
