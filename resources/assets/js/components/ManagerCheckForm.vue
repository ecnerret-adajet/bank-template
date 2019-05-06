<template>
    <div>

        <div class="jumbotron">
            <div class="row">
                <div class="col">
                    <span class="text-muted text-uppercase small">Bank Name:</span> <br/>
                    <span class="h4 text-dark" v-if="selectedBank">  {{ getSelectedBank.name }} </span>
                    <span class="h4 text-dark" v-else> N/A </span>
                </div>
                 <div class="col">
                    <span class="text-muted text-uppercase small">Branch Manager:</span> <br/>
                    <span class="h4 text-dark" v-if="selectedBank">  {{ getSelectedBank.manager.full_name }} </span>
                    <span class="h4 text-dark" v-else> N/A </span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <span class="text-muted text-uppercase small">Company</span><br/>
                    <span class="h4 text-dark" v-if="selectedAccount"> {{ companyFromAccount.company.name }} </span>
                    <span class="h4 text-dark" v-else> N/A </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Bank Branch</label>
                    <select class="form-control" name="bank_list" v-model="selectedBank">
                        <option value="" disabled selected>Select Bank Branch</option>
                        <option v-for="(bank,i) in banks" :key="i" selected :value="bank.id">{{ bank.name + ' - ' + bank.branch }}</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Account Number</label>
                    <select class="form-control" v-model="selectedAccount">
                        <option value="" disabled selected>Select Account Number</option>
                        <option v-for="(account, a) in getAccountNumber" :key="a" :value="account.id">{{ account.account_company }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                    <app-m-c-form-table :user_id="user_id"
                                        @getMcCost="mc_cost = $event"
                                        @getGrandTotal="grand_total = $event">
                    </app-m-c-form-table>
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
                <button type="submit" class="btn btn-primary btn-block" :disabled="allowToSubmit" @click.prevent="postManagerCheck">Publish</button>
            </div>
        </div>


    </div>
</template>
<script>
import MCFormTable from './MCFormTable.vue';
export default {

    props: ['user_id'],

    components: {
        appMCFormTable : MCFormTable
    },

    data() {
        return {
            banks: [],
            signatories: [],
            signatories2: [],
            selectedBank: '',
            selectedAccount: '',
            mc_cost: '',
            grand_total: '',
            signatory1: '',
            signatory2: '',
        }
    },

    created() {
        this.getBank()
        this.getSignatories()
    },

    methods: {
        getBank() {
            axios.get('/getBanks')
            .then(response => this.banks = response.data)
        },

        getSignatories() {
            if(this.selectedAccount != '') {
                axios.get(`/api/assigned-signatories/${this.companyFromAccount.company.id}`)
                .then(response  => {
                    let resultCopy = [...response.data]
                    this.signatories = response.data.filter(item => item.policy_type === 1);
                    this.signatories2 = resultCopy.filter(item => item.policy_type === 2);
                })
            }
        },

        postManagerCheck() {
            axios.post('/manager-checks', {
                bank_id: this.selectedBank,
                account_id : this.selectedAccount,
                signatory1 : this.signatory1,
                signatory2 : this.signatory2,
                mc_cost : this.mc_cost,
                grand_total : this.grand_total
            })
            .then(response => {
                window.location = response.data.redirect;
            })
            .catch((error) => {
                console.log(error);
            })
        }
    },

    computed: {
         allowToSubmit() {
            return this.selectedBank == '' ||
                this.selectedAccount == '' ||
                this.mc_cost == '' ||
                this.grand_total == '' ||
                this.signatory1 == '';
        },

        getSelectedBank() {
            if(this.selectedBank) {
                return this.banks.filter(bank => bank.id == this.selectedBank)[0];
            }
        },

        getAccountNumber () {
            if(this.selectedBank) {
                return this.getSelectedBank.accounts.map(account => account);
            }
        },

        companyFromAccount() {
            if(this.selectedAccount) {
                return this.getAccountNumber.filter(account => account.id == this.selectedAccount)[0];
            }
        },

        // secondSignatory() {
        //     if(this.signatory1) {
        //         return this.signatories.filter(signatory => signatory.full_name != this.signatory1);
        //     }
        // },
    },

    watch: {
        selectedBank() {
            this.selectedAccount = '';
        },
        selectedAccount() {
            this.getSignatories()
        }
    }


}
</script>
