<template>
    <div>
        <div v-for='(mail, i) in mailCategories' :key='i'>
            <p>{{ mail.annotation }}</p>
            <input
                :id="'mail-category' + i"
                type="checkbox"
                :value="mail.id"
                v-model="checkedCategories"
            >

        </div>
        <button v-on:click="postArticle">保存</button>
    </div>
</template>


<script>
    export default {
        props: {
            mailCategories: {
                type: Object
            },
        },
        data() {
            return {
                checkedCategories: []
            };
        },
        methods: {
            postArticle(){
                var mailCheckboxes = {
                };

                // axios.post('/api/article/' + mailCheckboxes).then(res => {
                // });
            }
        }
    }
</script>