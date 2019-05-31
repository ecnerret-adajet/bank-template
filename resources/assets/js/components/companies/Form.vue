<template>
<!-- Add New Bank Modal -->
    <div class="modal fade" id="newCompany" tabindex="-1" role="dialog" aria-labelledby="newCompanyLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="newCompanyLabel">Add New Company</h5>
                <button type="button" class="close"  @click="closeForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group" :class="{ ' has-danger' : errors.name }">
                    <label>Company Name</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.name }" v-model="toSubmit.name" placeholder="Enter Company name">
                    <!-- <input type="text" class="form-control" id="name" v-model="toSubmit.name" :class="{ 'is-invalid' : errors.name }" placeholder="Enter Name"> -->
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                </div>

                 <div class="form-group" :class="{ ' has-danger' : errors.department }">
                    <label>Department</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.department }" v-model="toSubmit.department" placeholder="Enter Department">
                    <div v-if="errors.department" class="invalid-feedback">{{ errors.department[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.abbrv }">
                    <label>Abbrv</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.abbrv }" v-model="toSubmit.abbrv" placeholder="Enter Abbreviation">
                    <div v-if="errors.abbrv" class="invalid-feedback">{{ errors.abbrv[0] }}</div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeForm">Cancel</button>
                <button type="button" :disabled="loading" class="btn btn-primary" @click.prevent="storeCompany">Submit</button>
            </div>


            </div>
        </div>
        </div>
</template>
<script>
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import Toasted from 'vue-toasted';

export default {

    props: ['showModal','isCreate'],

    components: {
        VueBootstrapTypeahead
    },

    data() {
        return {
            errors: [],
            loading: false,
            toSubmit: {
                name: '',
                department: '',
                abbrv: ''
            },

        }
    },

    watch: {
        showModal() {
             if(this.showModal == true) {
                $('#newCompany').modal('show')
            }
        },
        toEdit() {
            if (this.isCreate === false || Object.keys(this.toEdit).length != 0) {
                this.toSubmit = this.toEdit
                this.$refs.typeahead.$data.inputValue = this.toEdit.name
            }
        }
    },

    methods: {
        resetFields() {
            this.toSubmit = {
                name: '',
                department: '',
                abbrv: ''
            }
        },

        returnMessage(message) {
            Vue.toasted.show(message, {
                theme: "primary",
                position: "bottom-right",
                duration : 5000
            });
        },

        storeCompany() {
            this.loading = true
            axios.post('/companies', {
                name : this.toSubmit.name,
                department : this.toSubmit.department,
                abbrv: this.toSubmit.abbrv
            })
            .then(response => {
                if(response.status === 201) {
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

        closeForm() {
            this.errors = []
            this.$emit('returnShowModal',false)
            $('#newCompany').modal('hide')
            this.loading = false
        }

    }

}
</script>
