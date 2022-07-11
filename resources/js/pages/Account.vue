<template>
    <div>
        <b-alert variant="success" v-show="showSuccessAlert" show>
            {{ successMessage }}
        </b-alert>
        <b-alert variant="danger" v-show="showErrorAlert" show>
            {{ errorMessage }}
        </b-alert>
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

        <b-modal v-model="modal" hide-footer centered>
            <div class="form-container container">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <div class="form-row">
                            <div class="col">
                                <b-form-input
                                    v-model="userName"
                                    placeholder="Name"
                                ></b-form-input>
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
                    <br />
                    <div class="btn-container">
                        <span class="btn btn-primary" @click="updateUser()">
                            Update
                        </span>
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
            users: {},
            roles: {},
            userId: null,
            userName: "",
            userEmail: "",
            successMessage: "",
            errorMessage: "",
            showSuccessAlert: false,
            showErrorAlert: false,
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
            this.userId = user.id;
            this.userName = user.name;
            this.userEmail = user.email;
            this.modal = true;
        },

        async updateUser() {
            const requestBody = {
                name: this.userName,
                email: this.userEmail,
            };

            const result = await axios.put(
                "api/users/" + this.userId,
                requestBody
            );

            if (result.status === 200) {
                this.successMessage = result.data.message;
                this.showSuccessAlert = true;
            } else {
                this.errorMessage = result.data.message;
                this.showErrorAlert = true;
            }

            this.getUsers();

            this.modal = false;
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

<style>
.modal-backdrop {
    opacity: 0.5;
}
</style>
