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
            console.log('test');
            axios.get('/api/dashboard').then((response) => {
                this.response = response.data;
                console.log(response.data);
            }).catch((error) => {
                console.error(error);
            });
        }
    }
    }
</script>
