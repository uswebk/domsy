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
            axios.get('/api/menus').then((response) => {
                this.response = response.data;
                console.log(response.data);
            }).catch((error) => {
                console.error(error);
            });
        }
    }
    }
</script>
