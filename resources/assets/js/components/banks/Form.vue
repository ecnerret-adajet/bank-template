<template>
<!-- Add New Bank Modal -->
    <div class="modal fade" id="newBank" tabindex="-1" role="dialog" aria-labelledby="newBankLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="newBankLabel">Add New Bank</h5>
                <button type="button" class="close"  @click="closeForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group" :class="{ ' has-danger' : errors.name }">
                    <label>Bank Name</label>
                    <vue-bootstrap-typeahead
                    type="text"
                    placeholder="Enter Bank Name.."
                    class="form-control"
                    v-model="toSubmit.name"
                    :data="banks"
                    />
                    <!-- <input type="text" class="form-control" id="name" v-model="toSubmit.name" :class="{ 'is-invalid' : errors.name }" placeholder="Enter Name"> -->
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                </div>

                 <div class="form-group" :class="{ ' has-danger' : errors.branch }">
                    <label>Branch</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.branch }" v-model="toSubmit.branch" placeholder="Enter Branch">
                    <div v-if="errors.branch" class="invalid-feedback">{{ errors.branch[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.location }">
                    <label>Location</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.location }" v-model="toSubmit.location" placeholder="Enter Location">
                    <div v-if="errors.location" class="invalid-feedback">{{ errors.location[0] }}</div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeForm">Cancel</button>
                <button v-if="isCreate === false" type="button" class="btn btn-primary" :disabled="loading" @click.prevent="updateBank">Update</button>
                <button v-else type="button" :disabled="loading" class="btn btn-primary" @click.prevent="storeBank">Submit</button>
            </div>


            </div>
        </div>
        </div>
</template>
<script>
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import Toasted from 'vue-toasted';

export default {

    props: ['toEdit','showModal','isCreate','banks'],

    components: {
        VueBootstrapTypeahead
    },

    data() {
        return {
            errors: [],
            loading: false,
            toSubmit: {
                name: '',
                branch: '',
                location: ''
            },

        }
    },

    watch: {
        showModal() {
             if(this.showModal == true) {
                $('#newBank').modal('show')
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

        storeBank() {
            this.loading = true
            axios.post('/banks', {
                name : this.toSubmit.name,
                branch : this.toSubmit.branch,
                location: this.toSubmit.location
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

        updateBank() {
            this.loading = true
            axios.put(`/banks/${this.toSubmit.id}`,{
                name : this.toSubmit.name,
                branch : this.toSubmit.branch,
                location: this.toSubmit.location
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
            $('#newBank').modal('hide')
            this.loading = false
        }

    }

}
</script>
