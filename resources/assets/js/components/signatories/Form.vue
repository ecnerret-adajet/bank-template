<template>
    <div class="modal fade" id="newSignatory" tabindex="-1" role="dialog" aria-labelledby="newSignatoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSignatoryLabel">Add New Signatory</h5>
                <button type="button" class="close"  @click="closeForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group" :class="{ ' has-danger' : errors.first_name }">
                    <label>First Name</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid' : errors.first_name }" v-model="toSubmit.first_name" placeholder="Enter First Name">
                    <div v-if="errors.first_name" class="invalid-feedback">{{ errors.first_name[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.middle_name }">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid' : errors.middle_name }"  v-model="toSubmit.middle_name" placeholder="Enter Middle Name">
                     <div v-if="errors.middle_name" class="invalid-feedback">{{ errors.middle_name[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.last_name }">
                    <label>Last Name</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid' : errors.last_name }"  v-model="toSubmit.last_name" placeholder="Enter Last Name">
                    <div v-if="errors.last_name" class="invalid-feedback">{{ errors.last_name[0] }}</div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeForm">Cancel</button>
                <button v-if="isCreate === false" type="button" class="btn btn-primary" :disabled="loading" @click.prevent="updateSignatory">Update</button>
                <button v-else type="button" :disabled="loading" class="btn btn-primary" @click.prevent="storeSignatory">Submit</button>
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
            loading: false,
            toSubmit: {
                first_name: '',
                middle_name: '',
                last_name: '',
            }
        }
    },

    watch: {
        showModal() {
             if(this.showModal == true) {
                $('#newSignatory').modal('show')
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
            this.toSubmit = {
                first_name: '',
                middle_name: '',
                last_name: '',
            }
        },

        returnMessage(message) {
            Vue.toasted.show(message, {
                theme: "primary",
                position: "bottom-right",
                duration : 5000
            });
        },

        storeSignatory() {
            this.loading = true
            axios.post('/signatories', {
                first_name: this.toSubmit.first_name,
                middle_name: this.toSubmit.middle_name,
                last_name: this.toSubmit.last_name
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

        updateSignatory() {
            this.loading = true
            axios.put(`/signatories/${this.toSubmit.id}`,{
                first_name: this.toSubmit.first_name,
                middle_name: this.toSubmit.middle_name,
                last_name: this.toSubmit.last_name
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
            $('#newSignatory').modal('hide')
            this.loading = false
        }

    }


}
</script>

