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

        <b-modal v-model="modal" hide-footer>
            <div class="form-container container">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <div class="form-row">
                            <div class="col">
                                <b-form-input v-model="userName" placeholder="Name"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input
                            v-model="userEmail"
                            type="email"
                            class="form-control"
                            id="email"
                            placeholder="domsy@example.com"
                        />
                    </div>
                    <br>
                    <div class="btn-container">
                        <button type="submit" class="btn btn-primary">
                            更新
                        </button>
                    </div>
                </form>
            </div>
        </b-modal>
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
            userName:'',
            userEmail:'',
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
            this.userName = user.name;
            this.userEmail = user.email;
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
