<template>
    <div>

        <div class="jumbotron">
            <div class="row mb-2">
                <div class="col">
                    <span class="text-muted text-uppercase small">Bank Name:</span> <br/>
                    <span class="h4 text-dark" v-if="selectedNearBank"> {{ getSelectedBank.name }} </span>
                    <span class="h4 text-dark" v-else> N/A </span>
                </div>
                <div class="col">
                    <span class="text-muted text-uppercase small">Branch:</span> <br/>
                    <span class="h4 text-dark" v-if="selectedNearBank"> {{ getSelectedBank.branch }} </span>
                    <span class="h4 text-dark" v-else> N/A </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Application Type</label>
                    <select class="form-control"  v-model="selectedType">
                        <option value="" disabled selected>Select Application Type</option>
                        <option v-for="(type,t) in types" :key="t" selected :value="type.id">{{ type.name }}</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Company</label>
                    <select class="form-control"  v-model="selectedCompany">
                        <option value="" disabled selected>Select Company</option>
                        <option v-for="(company,c) in companies" :key="c" selected :value="company.id">{{ company.department ? company.department + ' - ' + company.name : company.name }}</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Bank Branch</label>
                    <select class="form-control"  v-model="selectedNearBank">
                        <option value="" disabled selected>Select Branch Manager</option>
                        <option v-for="(manager,m) in nearBanks" :key="m" selected :value="manager.id">{{ manager.name + ' - ' + manager.branch }}</option>
                    </select>
                    <div v-if="emptyNearBank" class="text-danger">No assigned near bank branch found.</div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <app-payroll-form-table :user_id="user_id" :banks="nearBanks"></app-payroll-form-table>
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
                <button type="submit" class="btn btn-primary btn-block" :class="{ disabled : allowToSubmit }" :disabled="allowToSubmit" @click.prevent="postPayroll">Publish</button>
            </div>
        </div>

    </div>
</template>
<script>
import PayrollFormTable from './PayrollFormTable.vue';
export default {

    props: ['user_id'],

    components: {
        appPayrollFormTable: PayrollFormTable
    },

    data() {
        return {
            types: [],
            nearBanks: [],
            companies: [],
            signatories: [],
            signatories2: [],
            emptyNearBank: false,
            selectedCompany: '',
            selectedNearBank: '',
            selectedType: '',
            signatory1: '',
            signatory2: '',
        }
    },

    created() {
        this.getPayrollTypes()
        this.getCompanies()
        this.getSignatories()
        // this.getManagers()
    },

    watch: {
        selectedCompany() {
            this.getNearestBank()
            this.getSignatories()
        }
    },

    methods: {

        getPayrollTypes() {
            axios.get('/getPayrollTypes')
            .then(response  => this.types = response.data);
        },

        getCompanies() {
            axios.get('/getCompanies')
            .then(response => this.companies = response.data);
        },

        getSignatories() {
            if(this.selectedCompany != '') {
                axios.get(`/api/assigned-signatories/${this.selectedCompany}`)
                .then(response  => {
                    let resultCopy = [...response.data]
                    this.signatories = response.data.filter(item => item.policy_type === 1);
                    this.signatories2 = resultCopy.filter(item => item.policy_type === 2);
                })
            }
        },

        getNearestBank() {
            this.nearBanks = []
            this.selectedNearBank = ''
            axios.get(`/api/companies-near-branch/${this.selectedCompany}`)
            .then(response => {
                return response.data.map(item => {
                    console.log('bank count: ', item.banks.length)
                    console.log('bank items: ', item.banks)
                    if(item.banks.length > 0) {
                        this.emptyNearBank = false
                        this.nearBanks = item.banks
                    }

                    if(item.banks.length == 0) {
                        this.emptyNearBank = true
                        this.nearBanks = []
                        this.selectedNearBank = ''
                    }
                })
            })
        },

        // getManagers() {
        //     axios.get('/getManagers')
        //     .then(response => this.nearBanks = response.data);
        // },

        postPayroll() {
            axios.post('/payrolls', {
                manager_list: this.selectedManager,
                payroll_type: this.selectedType,
                company_list: this.selectedCompany,
                signatory1: this.signatory1,
                signatory2: this.signatory2,
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

        selectedManager() {
            let selectedBank = this.nearBanks.find(item => item.id === this.selectedNearBank);
            return selectedBank.manager.id;
        },

        nearestBank() {
            return this.nearBanks.filter(item)
        },

        allowToSubmit() {
            return this.selectedType == '' ||
                this.selectedCompany == '' ||
                this.selectedNearBank == '' ||
                this.signatory1 == '';
        },


        getSelectedBank() {
            if(this.selectedNearBank) {
                return this.nearBanks.filter(manager => manager.id == this.selectedNearBank)[0];
            }
        }

    }


}
</script>
<style scoped>
    .disabled {
        cursor: not-allowed;
    }
</style>

