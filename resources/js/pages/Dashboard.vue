<template>
    <div class='d-flex justify-content-left flex-wrap' >
        <div class='card w-25 m-1' v-for="menu in menus" :key="menu.id">
            <div class='card-body'>
                <h5 class='card-title'> {{ menu.name }} </h5>
                <h6 class="card-subtitle mb-2 text-muted"></h6>

                <div v-for="menu_item in menu.menu_items" :key="menu_item.id">
                    <a href='' class='card-link' v-if="menu_item.is_screen">
                        {{ menu_item.name }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>



<script>

export default {
    data () {
        return {
            menus: ''
        };
    },
    created() {
        this.getMenus();
    },
    methods: {
        getMenus () {
            axios.get('dashboard/menus').then((response) => {
                this.menus = response.data.menus;

                console.log(this.menus);
            }).catch((error) => {
                console.error(error);
            });
        }
    }
}

</script>
