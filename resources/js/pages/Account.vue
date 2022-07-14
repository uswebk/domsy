<template>
  <div>
    <b-alert variant="success" v-show="showSuccessAlert" show>
      {{ successMessage }}
    </b-alert>
    <b-alert variant="danger" v-show="showErrorAlert" show>
      {{ errorMessage }}
    </b-alert>
    <table class="table mt-2">
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
          <button type="button" class="btn mr-1" @click="editModal(user)">
            Edit
          </button>
          <button type="button" class="btn mr-1" @click="deleteUser(user)">
            Delete
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
                  class="form-control"
                  v-model="userName"
                  placeholder="Name"
                ></b-form-input>
                <div v-if="errors.name">
                  <p class="text-danger">
                    {{ errors.name[0] }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <div class="form-row">
              <div class="col">
                <b-form-input
                  v-model="userEmail"
                  type="email"
                  placeholder="domsy@example.com"
                ></b-form-input>
                <div v-if="errors.email">
                  <p class="text-danger">
                    {{ errors.email[0] }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <div class="form-row">
              <div class="col">
                <b-form-select
                  v-model="userRoleId"
                  :options="roles"
                  class="mb-3"
                  value-field="id"
                  text-field="name"
                  disabled-field="notEnabled"
                ></b-form-select>
                <div v-if="errors.role_id">
                  <p class="text-danger">
                    {{ errors.role_id[0] }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <br />
          <div class="btn-container">
            <span class="btn btn-primary" @click="updateUser()"> Update </span>
          </div>
        </form>
      </div>
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      modal: false,
      users: {},
      roles: {},
      userId: null,
      userName: '',
      userEmail: '',
      userRoleId: null,
      successMessage: '',
      errorMessage: '',
      showSuccessAlert: false,
      showErrorAlert: false,
      errors: {},
    }
  },

  methods: {
    openModal() {
      this.modal = true
    },

    closeModal() {
      this.modal = false
    },

    resetErrors() {
      this.errors = {}
    },

    editModal(user) {
      this.userId = user.id
      this.userName = user.name
      this.userEmail = user.email
      this.userRoleId = user.role_id
      this.resetErrors()
      this.modal = true
    },

    async updateUser() {
      try {
        const result = await axios.put('api/users/' + this.userId, {
          name: this.userName,
          email: this.userEmail,
          role_id: this.userRoleId,
        })

        if (result.status === 200) {
          this.successMessage = result.data.message
          this.showSuccessAlert = true
        }

        this.getUsers()
        this.resetErrors()
        this.modal = false
      } catch (error) {
        if (error.response.status === 422) {
          this.errors = error.response.data.errors
        } else {
          this.showErrorAlert = 'UpdateFails'
          this.showErrorAlert = true
        }
      }
    },

    deleteUser(user) {
      console.log(user)
    },

    async getUsers() {
      const result = await axios.get('api/users')
      this.users = result.data
    },

    async getRoles() {
      const result = await axios.get('api/roles')

      this.roles = result.data
    },

    async initialize() {
      this.getUsers()
      this.getRoles()
    },
  },

  created() {
    this.initialize()
  },
}
</script>

<style>
.modal-backdrop {
  opacity: 0.5;
}
</style>
