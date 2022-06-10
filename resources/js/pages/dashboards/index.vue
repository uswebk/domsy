<template>
    <div>
        <h3>- Dashboard</h3>

        <div class='d-flex justify-content-left flex-wrap'>
            <div class='card w-25 m-1' v-for='menu in menus' :key='menu.id'>
                <a v-bind:href='`${ menu.link }`' class='text-reset' style='text-decoration:none;'>
                    <div class='card-body'>
                        <h5 class='card-title'>{{ menu.name }}</h5>
                        <p class='card-text' style='color:gray'>{{ menu.description }}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:{
            menus:{
                type: Array,
                required: true
            }
        }
    }
</script>