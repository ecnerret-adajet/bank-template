<template>
    <div>

        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Accounts</span>
                <button type="button" class="float-right btn btn-primary"  data-toggle="modal" data-target="#newAccount">
                    Add Account
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="search" placeholder="Search Account Number">
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col" class="text-dark" >Account Number</th>
                <th scope="col" class="text-dark" >Company</th>
                <th scope="col" class="text-dark" >Bank</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(account, a) in filteredQueues" :key="a" v-if="!loading">
                    <td>{{ account.account_number }}</td>
                    <td>{{ account.bank }}</td>
                    <td>{{ account.company.name }}</td>
                </tr>
                <tr v-if="filteredQueues.length == 0 && !loading">
                    <td colspan="3" class="text-center" >
                        <h3>Nothing found</h3>
                    </td>
                </tr>
                <tr v-if="loading">
                    <td colspan="5">
                         <div class="row">
                            <div class="col">
                                <content-placeholders style="border: 0 ! important;" :rounded="true">
                                    <content-placeholders-heading :img="true" />
                                    <content-placeholders-text :lines="1" />
                                    <hr/>
                                    <content-placeholders-heading :img="true" />
                                    <content-placeholders-text :lines="1" />
                                    <hr/>
                                    <content-placeholders-heading :img="true" />
                                    <content-placeholders-text :lines="1" />
                                    <hr/>
                                    <content-placeholders-heading :img="true" />
                                    <content-placeholders-text :lines="1" />
                                    <!-- <content-placeholders-text :lines="3" /> -->
                                </content-placeholders>
                             </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table> 

        <div class="row mt-3">
            <div class="col-6">
                <button :disabled="!showPreviousLink()" class="btn btn-default btn-sm" v-on:click="setPage(currentPage - 1)"> Previous </button>
                    <span class="text-dark">Page {{ currentPage + 1 }} of {{ totalPages }}</span>
                <button :disabled="!showNextLink()" class="btn btn-default btn-sm" v-on:click="setPage(currentPage + 1)"> Next </button>
            </div>
            <div class="col-6 text-right">
                <span>{{ accounts.length }} Manager(s)</span>
            </div>
        </div>


        <!-- Add New Bank Modal -->
        <div class="modal fade" id="newAccount" tabindex="-1" role="dialog" aria-labelledby="newAccountLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAccountLabel">Add New Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label>Bank Name</label>
                    <select class="form-control" v-model="selectedBank">
                        <option value=""  selected>All Banks</option>
                        <option v-for="(bank,i) in banks" :key="i" selected :value="bank.id">{{ bank.branch }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Company</label>
                    <select class="form-control" v-model="selectedCompany">
                        <option value=""  selected>All Companies</option>
                        <option v-for="(company,c) in companies" :key="c" selected :value="company.id">{{ company.name }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" class="form-control acc_format" id="name" v-model="account_number" placeholder="Enter Account Number">
                </div>

            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="validateFields" @click.prevent="storeAccount" data-dismiss="modal">Submit</button>            
            </div>
            </div>
        </div>
        </div>


    </div>
</template>
<script>

import Toasted from 'vue-toasted';
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';

Vue.use(Toasted)

export default {

    components: {
        VueContentPlaceholders,
    },

    data() {
        return {
            loading: false,
            accounts: [],
            banks: [],
            companies: [],
            account_number: '',
            selectedBank: '',
            selectedCompany: '',
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    mounted() {
        $(document).ready(function(){
            $('.acc_format').inputmask("9999 9999 99",{ placeholder: "" });
        });
    },

    created() {
        this.getAccounts()
        this.getBanks()
        this.getCompanies()
    },

    methods: {
        resetFields() {
            this.account_number = '';
            this.selectedBank = '';
            this.selectedCompany = '';
        },

        getAccounts() {
            axios.get('/getAccounts')
            .then(response => this.accounts = response.data)
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
            axios.post('/accounts', {
                account_number : this.account_number,
                bank_list : this.selectedBank,
                company_list : this.selectedCompany
            })
            .then(response => {
                this.accounts.unshift(response.data)
                console.log(response.data)
                Vue.toasted.show("Added Successfully!", { 
                    theme: "primary", 
                    position: "bottom-right", 
                    duration : 5000
                });
            })
            this.resetFields()
        },

        setPage(pageNumber) {
            this.currentPage = pageNumber;
        },

        resetStartRow() {
            this.currentPage = 0;
        },

        showPreviousLink() {
            return this.currentPage == 0 ? false : true;
        },

        showNextLink() {
            return this.currentPage == (this.totalPages - 1) ? false : true;
        }

    },

    computed: {
        validateFields() {
            return this.selectedBank == '' ||
                    this.selectedCompany == '' ||
                    this.account_number == '';
        },

        filteredEntries() {
            return this.accounts.filter(item => {
                return item.account_number.toLowerCase().includes(this.search.toLowerCase());
            })
        },

        currentDate() {
            return moment().format('YYYY-MM-DD');
        },

        totalPages() {
            return Math.ceil(this.filteredEntries.length / this.itemsPerPage)
        },
        
        filteredQueues() {
            var index = this.currentPage * this.itemsPerPage;
            var queues_array = this.filteredEntries.slice(index, index + this.itemsPerPage);

            if(this.currentPage >= this.totalPages) {
                this.currentPage = this.totalPages - 1
            }

            if(this.currentPage == -1) {
                this.currentPage = 0;
            }

            return queues_array;
        }
    }
}
</script>
