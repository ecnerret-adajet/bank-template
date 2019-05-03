<template>

<div class="modal fade" id="newManager" tabindex="-1" role="dialog" aria-labelledby="newManagerLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newManagerLabel">Add New Manager</h5>
                <button type="button" class="close"  @click="closeForm" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                 <div class="form-group" :class="{ ' has-danger' : errors.bank_list }">
                    <label>Bank Name</label>
                    <select class="form-control" v-model="toSubmit.selectedBank" :class="{ 'is-invalid' : errors.bank_list }">
                        <option value=""  selected>All Banks</option>
                        <option v-for="(bank,i) in banks" :key="i" selected :value="bank.id">{{ bank.branch }}</option>
                    </select>
                    <div v-if="errors.bank_list" class="invalid-feedback">{{ errors.bank_list[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.title }">
                    <label>Title</label>
                    <select class="form-control" :class="{ 'is-invalid' : errors.title }" v-model="toSubmit.title">
                        <option value=""  selected>Select Title</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Mr.">Mr.</option>
                    </select>
                    <div v-if="errors.title" class="invalid-feedback">{{ errors.title[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.first_name }">
                    <label>First Name</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid' : errors.first_name }" id="name" v-model="toSubmit.first_name" placeholder="Enter First Name">
                    <div v-if="errors.first_name" class="invalid-feedback">{{ errors.first_name[0] }}</div>
                </div>

                 <div class="form-group" :class="{ ' has-danger' : errors.middle_name }">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" id="name" v-model="toSubmit.middle_name" :class="{ 'is-invalid' : errors.middle_name }" placeholder="Enter Middle Name">
                    <div v-if="errors.middle_name" class="invalid-feedback">{{ errors.middle_name[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.last_name }">
                    <label>Last Name</label>
                    <input type="text" class="form-control" id="name" v-model="toSubmit.last_name" :class="{ 'is-invalid' : errors.last_name }" placeholder="Enter Last Name">
                    <div v-if="errors.last_name" class="invalid-feedback">{{ errors.last_name[0] }}</div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeForm">Cancel</button>
                <button v-if="isCreate === false" type="button" class="btn btn-primary" :disabled="loading" @click.prevent="updateManager">Update</button>
                <button v-else type="button" :disabled="loading" class="btn btn-primary" @click.prevent="storeManager">Submit</button>
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
                selectedBank: '',
                title: '',
                first_name: '',
                middle_name: '',
                last_name: '',
            },

        }
    },

    mounted() {
        this.getBanks()
    },

    watch: {
        showModal() {
             if(this.showModal == true) {
                $('#newManager').modal('show')
            }
        },
        toEdit() {
            if (this.isCreate === false || Object.keys(this.toEdit).length != 0) {
                this.toSubmit = this.toEdit
                this.toSubmit.selectedBank = this.toEdit.bank.id
            }
        }
    },

    methods: {

         getBanks() {
            axios.get('/getBanks')
            .then(response => this.banks = response.data);
        },

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

        storeManager() {
            this.loading = true
            axios.post('/managers', {
                bank_list : this.toSubmit.selectedBank,
                title : this.toSubmit.title,
                first_name: this.toSubmit.first_name,
                middle_name: this.toSubmit.middle_name,
                last_name: this.toSubmit.last_name,
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

        updateManager() {
            this.loading = true
            axios.put(`/managers/${this.toSubmit.id}`,{
                bank_list : this.toSubmit.selectedBank,
                title : this.toSubmit.title,
                first_name: this.toSubmit.first_name,
                middle_name: this.toSubmit.middle_name,
                last_name: this.toSubmit.last_name,
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
            this.$emit('returnToEdit', {})
            this.$emit('returnShowModal',false)
            $('#newManager').modal('hide')
            this.loading = false
        }




    }

}
</script>

