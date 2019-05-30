<template>
    <div>



        <div class="jumbotron">
            <div class="row mb-2" v-if="selectedBank" v-for="(selected, s) in getSelectedBank" :key="s">
                <div class="col">
                    <span class="text-muted text-uppercase small">Bank Name:</span> <br/>
                <span class="h4 text-dark"> {{ selected.name }} </span>
                </div>
                <div class="col">
                    <span class="text-muted text-uppercase small">Assigned Manager:</span> <br/>
                <span class="h4 text-dark"> {{ selected.manager.full_name }} </span>
                </div>
            </div>
            <div class="row mb-2" v-if="!selectedBank">
                <div class="col">
                    <span class="text-muted text-uppercase small">Bank Name:</span> <br/>
                    <span class="h4 text-dark"> N/A </span>
                </div>
                <div class="col">
                    <span class="text-muted text-uppercase small">Assigned Manager:</span> <br/>
                    <span class="h4 text-dark"> N/A </span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <span class="text-muted text-uppercase small">From Company:</span> <br/>
                    <span class="h4 text-dark" v-if="selectedFromAccount">  {{ fromCompany.company.name }} </span>
                    <span class="h4 text-dark" v-else>  N/A </span>
                </div>
                 <div class="col">
                    <span class="text-muted text-uppercase small">To Company:</span> <br/>
                    <span class="h4 text-dark" v-if="selectedToAccount"> {{ toCompany.company.name }} </span>
                    <span class="h4 text-dark" v-else>  N/A </span>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Bank Branch</label>
                    <select class="form-control" name="bank_list" v-model="selectedBank">
                        <option value="" disabled selected>Select Bank Branch</option>
                        <option v-for="(bank,i) in banks" :key="i" selected :value="bank.id">{{  bank.name + ' - ' + bank.branch }}</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="row">

                <div class="col">
                <div class="form-group">
                    <label>From Account</label>
                    <select class="form-control" name="from_account" v-model="selectedFromAccount">
                        <option value="" disabled selected>Select Account Number</option>
                        <option v-for="(account,a) in fromAccount" :key="a" selected :value="account.id">{{  account.company.location ? account.account_company + ' - ' + account.company.location.name : account.account_company  }}</option>
                    </select>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>To Account</label>
                    <select class="form-control" name="to_account" v-model="selectedToAccount">
                        <option value="" disabled selected>Select Account Number</option>
                        <option v-for="(account,a) in toAccount" :key="a" selected :value="account.id">{{ account.company_location }}</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" v-model.lazy="amount" name="amount" v-money="moneyConfig">
                </div>
            </div>
        </div>

         <div class="row">

            <div class="col">
                <div class="form-group">
                    <label>Signatory #1</label>
                    <select class="form-control" name="signatory1" v-model="signatory1">
                        <option value="" disabled selected>Select Signatory</option>
                        <option v-for="(signatory,s) in signatories" :key="s" selected :value="signatory.full_name">{{ signatory.full_name }}</option>
                    </select>
                </div>
            </div>

            <div v-show="signatories2.length > 0" class="col">
                <div class="form-group">
                    <label>Signatory #2</label>
                    <select class="form-control" name="signatory2" v-model="signatory2">
                        <option value="" disabled selected>Select Signatory</option>
                        <option v-for="(signatory,s) in signatories2" :key="s" selected :value="signatory.full_name">{{ signatory.full_name }}</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary btn-block" :disabled="allowToSubmit" @click.prevent="postBankTransfer">Publish</button>
            </div>
        </div>

    </div>
</template>
<script>
import {VMoney} from 'v-money'
export default {

    directives: {VMoney},

    data() {
        return {
            banks: [],
            signatories: [],
            signatories2: [],
            accounts: [],
            loadAccounts: false,
            selectedBank: '',
            selectedToAccount: '',
            selectedFromAccount: '',
            signatory1: '',
            signatory2: '',
            amount: '',
            moneyConfig: {
                // The character used to show the decimal place.
                // decimal: '.',
                // The character used to separate numbers in groups of three.
                thousands: ',',
                // The currency name or symbol followed by a space.
                prefix: 'PHP ',
                // The suffix (If a suffix is used by the target currency.)
                suffix: '',
                // Level of decimal precision. REQUIRED
                precision: 2,
                // If mask is false, outputs the number to the model. Otherwise outputs the masked string.
                masked: false
            }
        }
    },

    created() {
        this.getBank()
        this.getAllAccounts()
        this.getSignatories()
    },

    watch: {
        selectedBank() {
            this.selectedToAccount = '';
            this.selectedFromAccount = '';
        },
        selectedFromAccount() {
            this.getSignatories()
        }
    },


    methods: {
        getBank() {
            axios.get('/banks-accounts')
            .then(response => this.banks = response.data);
        },

        getAllAccounts() {
            this.loadAccounts = true;
            axios.get('/accounts')
            .then(response => {
                this.accounts = response.data
                this.loadAccounts = false;
            });
        },

        getSignatories() {
            if(this.selectedFromAccount != '') {
                 axios.get(`/api/assigned-signatories/${this.fromCompany.company.id}`)
                .then(response  => {
                    let resultCopy = [...response.data]
                    this.signatories = response.data.filter(item => item.policy_type === 1);
                    this.signatories2 = resultCopy.filter(item => item.policy_type === 2);
                })
            }
        },

        postBankTransfer() {
            axios.post('/bank-transfers', {
                amount: this.amount,
                from_account: this.selectedFromAccount,
                to_account: this.selectedToAccount,
                signatory1: this.signatory1,
                signatory2: this.signatory2,
                bank_list: this.selectedBank
            })
            .then(response => {
               window.location = response.data.redirect;
            })
            .catch((error) => {
                console.log(error);
            });
        }

    },

    computed: {
         allowToSubmit() {
            return this.selectedBank == '' ||
                this.selectedFromAccount == '' ||
                this.selectedToAccount == '' ||
                this.signatory1 == '' ||
                this.amount == 'PHP 0.00';
        },

        getSelectedBank() {
            if(this.selectedBank) {
                return this.banks.filter(bank => bank.id == this.selectedBank);
            }
        },

        fromAccount() {
            if(this.selectedBank) {
                return this.getSelectedBank.map(x => x.accounts.map(account => account))[0];
            }
        },

        toAccount() {
            if(this.selectedFromAccount) {
                // return this.getSelectedBank.map(x => x.accounts.filter(account => account.id != this.selectedFromAccount))[0];
                return this.accounts.filter(account => account.id != this.selectedFromAccount);
            }
        },

        fromCompany() {
            if(this.selectedFromAccount) {
                return this.fromAccount.filter(account => account.id == this.selectedFromAccount)[0];
            }
        },

        toCompany() {
            if(this.selectedToAccount) {
                return this.accounts.filter(account => account.id == this.selectedToAccount)[0];
            }
        },

        // secondSignatory() {
        //     if(this.signatory1) {
        //         return this.signatories.filter(signatory => signatory.full_name != this.signatory1);
        //     }
        // },

    }
}
</script>
