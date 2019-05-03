<template>
     <div class="modal fade" id="newAccount" tabindex="-1" role="dialog" aria-labelledby="newAccountLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAccountLabel">Add New Account</h5>
                <button type="button" class="close"  @click="closeForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group" :class="{ ' has-danger' : errors.bank_list }">
                    <label>Bank Name</label>
                    <select :class="{ 'is-invalid' : errors.bank_list }" class="form-control" v-model="toSubmit.bank_list">
                        <option value=""  selected>All Banks</option>
                        <option v-for="(bank,i) in banks" :key="i" selected :value="bank.id">{{ bank.name + " - " + bank.branch }}</option>
                    </select>
                    <div v-if="errors.bank_list" class="invalid-feedback">{{ errors.bank_list[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.company_list }">
                    <label>Company</label>
                    <select :class="{ 'is-invalid' : errors.company_list }" class="form-control" v-model="toSubmit.company_list">
                        <option value=""  selected>All Companies</option>
                        <option v-for="(company,c) in companies" :key="c" selected :value="company.id">{{ company.department ? company.department + " - " + company.name : company.name }}</option>
                    </select>
                    <div v-if="errors.company_list" class="invalid-feedback">{{ errors.company_list[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.account_number }">
                    <label>Account Number</label>
                    <input type="text" :class="{ 'is-invalid' : errors.account_number }" class="form-control acc_format" id="name" v-model="toSubmit.account_number" placeholder="Enter Account Number">
                    <div v-if="errors.account_number" class="invalid-feedback">{{ errors.account_number[0] }}</div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeForm">Cancel</button>
                <button v-if="isCreate === false" type="button" class="btn btn-primary" :disabled="loading" @click.prevent="updateAccount">Update</button>
                <button v-else type="button" :disabled="loading" class="btn btn-primary" @click.prevent="storeAccount">Submit</button>
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
            banks: [],
            companies: [],
            toSubmit: {
                bank_list: '',
                company_list: '',
                account_number: '',
            }
        }
    },

    mounted() {
        this.getBanks()
        this.getCompanies()
        $(document).ready(function(){
            $('.acc_format').inputmask("9999 9999 99",{ placeholder: "" });
        });
    },

    watch: {
        showModal() {
             if(this.showModal == true) {
                $('#newAccount').modal('show')
            }
        },
        toEdit() {
            if (this.isCreate === false || Object.keys(this.toEdit).length != 0) {
                this.toSubmit = this.toEdit
                if(Object.keys(this.toEdit).length != 0) {
                    this.toSubmit.bank_list = this.toEdit.bank.id
                    this.toSubmit.company_list = this.toEdit.company.id
                }
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

        getBanks() {
            axios.get('/getBanks')
            .then(response => this.banks = response.data)
        },

        getCompanies() {
            axios.get('/getCompanies')
            .then(response => this.companies = response.data)
        },

        storeAccount() {
            this.loading = true
            axios.post('/accounts', {
                account_number : this.toSubmit.account_number,
                bank_list : this.toSubmit.bank_list,
                company_list: this.toSubmit.company_list
            })
            .then(response => {
                if(response.status === 201) { // if has a resource
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

        updateAccount() {
            this.loading = true
            axios.put(`/accounts/${this.toSubmit.id}`,{
                account_number : this.toSubmit.account_number,
                bank_list : this.toSubmit.bank_list,
                company_list: this.toSubmit.company_list
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
            $('#newAccount').modal('hide')
            this.loading = false
        }


    }

}
</script>

