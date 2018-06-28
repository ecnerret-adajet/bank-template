<template>
    <div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Application Type</label>
                    <select class="form-control" name="payroll_type" v-model="selectedType">
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
                    <select class="form-control" name="payroll_type" v-model="selectedCompany">
                        <option value="" disabled selected>Select Company</option>
                        <option v-for="(company,c) in companies" :key="c" selected :value="company.id">{{ company.name }}</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Managers</label>
                    <select class="form-control" name="payroll_type" v-model="selectedManager">
                        <option value="" disabled selected>Select Branch Manager</option>
                        <option v-for="(manager,m) in managers" :key="m" selected :value="manager.id">{{ manager.full_name }}</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <app-payroll-form-table :user_id="user_id"></app-payroll-form-table>
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
 
            <div class="col">
                <div class="form-group">
                    <label>Signatory #2</label>
                    <select class="form-control" name="signatory2" v-model="signatory2">
                        <option value="" disabled selected>Select Signatory</option>
                        <option v-for="(signatory,s) in secondSignatory" :key="s" selected :value="signatory.full_name">{{ signatory.full_name }}</option>
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
            managers: [], 
            companies: [],
            signatories: [],
            selectedCompany: '',
            selectedManager: '',
            selectedType: '',    
            signatory1: '',
            signatory2: '',
        }
    },

    created() {
        this.getPayrollTypes()
        this.getCompanies()
        this.getSignatories()
        this.getManagers()
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
            axios.get('/getSignatories')
            .then(response  => this.signatories = response.data);
        },

        getManagers() {
            axios.get('/getManagers')
            .then(response => this.managers = response.data);
        },

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
        
        allowToSubmit() {
            return this.selectedType == '' ||
                this.selectedCompany == '' ||
                this.selectedManager == '' ||
                this.signatory1 == '' ||
                this.signatory2 == '';
        },

        secondSignatory() {
            if(this.signatory1) {
                return this.signatories.filter(signatory => signatory.full_name != this.signatory1);
            }
        },

    }


}
</script>
<style scoped>
    .disabled {
        cursor: not-allowed;
    }
</style>

