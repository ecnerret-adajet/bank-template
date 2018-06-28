<template>
    <div>

       

        <div class="jumbotron">
         <div class="row mb-2" v-for="(selected, s) in getSelectedBank" :key="s">
            <div class="col">
                <span class="text-muted text-uppercase small">Bank Name:</span> <br/>
               <span class="h4 text-dark"> {{ selected.name }} </span>
            </div>
            <div class="col">
                <span class="text-muted text-uppercase small">Assigned Manager:</span> <br/>
               <span class="h4 text-dark"> {{ selected.manager.full_name }} </span>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Bank Branch</label>
                    <select class="form-control" name="bank_list" v-model="selectedBank">
                        <option value="" disabled selected>Select Bank Branch</option>
                        <option v-for="(bank,i) in banks" :key="i" selected :value="bank.id">{{ bank.branch }}</option>
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
                        <option v-for="(account,a) in fromAccount" :key="a" selected :value="account.account_number">{{ account.account_number }}</option>
                    </select>
                </div>
            </div>
 
            <div class="col">
                <div class="form-group">
                    <label>To Account</label>
                    <select class="form-control" name="to_account" v-model="selectedToAccount">
                        <option value="" disabled selected>Select Account Number</option>
                        <option v-for="(account,a) in toAccount" :key="a" selected :value="account.account_number">{{ account.account_number }}</option>
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
                    <select class="form-control" name="from_account" v-model="signatory1">
                        <option value="" disabled selected>Select Signatory</option>
                        <option v-for="(signatory,s) in signatories" :key="s" selected :value="signatory.full_name">{{ signatory.full_name }}</option>
                    </select>
                </div>
            </div>
 
            <div class="col">
                <div class="form-group">
                    <label>Signatory #2</label>
                    <select class="form-control" name="from_account" v-model="signatory2">
                        <option value="" disabled selected>Select Signatory</option>
                        <option v-for="(signatory,s) in secondSignatory" :key="s" selected :value="signatory.full_name">{{ signatory.full_name }}</option>
                    </select>
                </div>
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
            companies: [],
            signatories: [],
            selectedBank: '',
            selectedToAccount: '',
            selectedFromAccount: '',
            signatory1: '',
            signatory2: '',
            amount: '',
            moneyConfig: {
                // The character used to show the decimal place.
                decimal: '.',
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
        this.getCompanies()
        this.getSignatories()
    },

    methods: {
        getBank() {
            axios.get('/getBanks')
            .then(response => this.banks = response.data);
        },

        getCompanies() {
            axios.get('/getCompanies')
            .then(response => this.companies = response.data);
        },        

        getSignatories() {
            axios.get('/getSignatories')
            .then(response  => this.signatories = response.data);
        }
    },

    computed: {
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
                return this.getSelectedBank.map(x => x.accounts.filter(account => account.account_number != this.selectedFromAccount))[0];
            }
        },

        secondSignatory() {
            if(this.signatory1) {
                return this.signatories.filter(signatory => signatory.full_name != this.signatory1);
            }
        }

        
    }
}
</script>
