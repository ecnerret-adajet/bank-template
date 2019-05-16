<template>
    <!-- Add New Bank Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add New User</h5>
                <button type="button" class="close"  @click="closeForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group" :class="{ ' has-danger' : errors.name }">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.name }" v-model="toSubmit.name" placeholder="Enter Name">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.email }">
                    <label>Email</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid' : errors.email }" id="email" v-model="toSubmit.email" placeholder="Enter Email">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.email[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.password }">
                    <label>Password</label>
                    <input type="password" class="form-control" :class="{ 'is-invalid' : errors.password }" id="password" v-model="toSubmit.password" placeholder="Enter Password">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.password[0] }}</div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" :class="{ 'is-invalid' : errors.password_confirmation }"  id="password_confirm" v-model="toSubmit.password_confirmation" placeholder="Enter Password">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeForm">Cancel</button>
                <button v-if="isCreate === false" type="button" class="btn btn-primary" :disabled="loading" @click.prevent="updateUser">Update</button>
                <button v-else type="button" :disabled="loading" class="btn btn-primary" @click.prevent="storeUser">Submit</button>
            </div>
            </div>
        </div>
        </div>
</template>
<script>
import Toasted from 'vue-toasted';

export default {

    props: ['toEdit','showModal','isCreate'],

    data() {
        return {
            errors: [],
            banks: [],
            loading: false,
            toSubmit: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
        }
    },

    watch: {
        showModal() {
             if(this.showModal == true) {
                $('#userModal').modal('show')
            }
        },
         toEdit() {
            if (this.isCreate === false || Object.keys(this.toEdit).length != 0) {
                this.toSubmit = this.toEdit
            }
        }
    },

    methods: {
        resetFields() {
            this.toSubmit = {}
        },

        returnMessage(message) {
            Vue.toasted.show(message, {
                theme: "primary",
                position: "bottom-right",
                duration : 5000
            });
        },

        storeUser() {
            this.loading = true
            axios.post('/users', {
                name : this.toSubmit.name,
                email : this.toSubmit.email,
                password: this.toSubmit.password,
                password_confirmation: this.toSubmit.password_confirmation
            })
            .then(response => {
                if(response.status === 200) {
                    // this.banks.unshift(response.data)
                    this.$emit('storeResponse', response.data)
                    return response.data
                }
            })
            .then(response => {
                this.returnMessage("Added successfully!")
                this.resetFields()
                this.closeForm()
            })
            .catch(error => {
                if(error.response.status == 422) {
                    this.errors = error.response.data.errors
                    this.loading = false
                }
            });
        },

        updateUser() {
            this.loading = true
            axios.put(`/users/${this.toSubmit.id}`,{
                name : this.toSubmit.name,
                email : this.toSubmit.email,
                password: this.toSubmit.password,
            })
            .then(response => {
                if(response.status === 200) {
                    this.$emit('editResponse', response.data)
                    return response.data
                }
            })
            .then(response => {
                this.returnMessage("Updated successfully!")
                this.resetFields()
                this.closeForm()
            })
            .catch(error => {
                if(error.response.status == 422) {
                    this.errors = error.response.data.errors
                    this.loading = false
                }
            });
        },

        closeForm(event) {
            this.errors = []
            this.resetFields()
            this.$emit('returnToEdit', {})
            this.$emit('returnShowModal',false)
            $('#userModal').modal('hide')
            this.loading = false
        }
    }

}
</script>

