<template>
    <div>
        <table class="table table-hover mt-2">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <tr v-for="user in users" :key="user.id">
                <td>
                    {{ user.name }}
                </td>
                <td>
                    {{ user.email }}
                </td>
                <td>
                    <button
                        type="button"
                        class="btn btn-light mr-1"
                        @click="editModal(user)"
                    >
                        edit
                    </button>
                </td>
            </tr>
        </table>

        <div class="form-container container" v-show="modal">
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <div class="form-row">
                        <div class="col">
                            <input
                                v-model="user.name"
                                type="text"
                                class="form-control"
                                placeholder="Name"
                            />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        v-model="user.email"
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="domsy@example.com"
                    />
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">更新</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            modal: false,
            user: "",
            users: {},
            roles: {},
        };
    },
    methods: {
        openModal() {
            this.modal = true;
        },
        closeModal() {
            this.modal = false;
        },
        editModal(user) {
            this.user = user;
            this.modal = true;
        },
        async getUsers() {
            const result = await axios.get("api/users");
            this.users = result.data;
        },
        async getRoles() {
            const result = await axios.get("api/roles");
            this.roles = result.data;
        },
        async initialize() {
            this.getUsers();
            this.getRoles();
        },
    },
    created() {
        this.initialize();
    },
};
</script>
