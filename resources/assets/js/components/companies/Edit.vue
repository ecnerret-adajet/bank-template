<template>
    <div>


        <div class="content-header mb-3 mt-4">
            <div class="row">
            <div class="col pt-3">
                <span class="h3 text-dark">Edit Company</span>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>


        <div class="row">
            <div class="col">
                    <div class="form-group" :class="{ ' has-danger' : errors.name }">
                    <label for="exampleSelect2">Company Name</label>
                    <input type="text" placeholder="Enter Company Name" class="form-control" :class="{ 'is-invalid' : errors.name }" v-model="toEdit.name">
                     <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group" :class="{ ' has-danger' : errors.department }">
                    <label for="exampleSelect2">Division</label>
                    <input type="text" placeholder="Enter Company Name" :class="{ 'is-invalid' : errors.department }" class="form-control" v-model="toEdit.department">
                     <div v-if="errors.department" class="invalid-feedback">{{ errors.department[0] }}</div>
                </div>
            </div>
            <div class="col">
                <div class="form-group" :class="{ ' has-danger' : errors.abbrv }">
                    <label for="exampleSelect2">Abbreviation</label>
                    <input type="text" placeholder="Enter Abbreviation" class="form-control" :class="{ 'is-invalid' : errors.abbrv }" v-model="toEdit.abbrv">
                    <div v-if="errors.abbrv" class="invalid-feedback">{{ errors.abbrv[0] }}</div>
                </div>
            </div>
        </div>

        <div class="content-header mb-3 mt-2">
            <div class="row">
            <div class="col pt-3">
                <span class="h3 text-dark">Assign Signatories</span>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

        <div class="row">


            <div class="col">
                <div  class="form-group" :class="{ ' has-danger' : errors.signatory1 }">
                    <label>Signatory #1 </label>
                    <Select2 v-model="signatory1" class="form-control" :class="{ 'is-invalid' : errors.signatory1 }" :settings="{ multiple: true }" :options="signatories" @change="myChangeEventSignatory1($event)" @select="mySelectEventSignatory1($event)" />
                    <div v-if="errors.signatory1" class="invalid-feedback">{{ errors.signatory1[0] }}</div>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>Signatory #2</label>
                    <Select2 v-model="signatory2" class="form-control" :settings="{ multiple: true }" :options="signatories2" @change="myChangeEventSignatory2($event)" @select="mySelectEventSignatory2($event)" />
                </div>
            </div>

        </div>

        <div class="content-header mb-3 mt-2">
            <div class="row">
            <div class="col pt-3">
                <span class="h3 text-dark">Nearest Bank Branch</span>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

        <div class="row">
            <div class="col">
                <div  class="form-group" :class="{ ' has-danger' : errors.bank_list }">
                    <label>Bank </label>
                    <Select2 v-model="selectedBank" class="form-control" :class="{ 'is-invalid' : errors.bank_list }" :settings="{ multiple: true }" :options="banks" @change="myChangeEventSignatory1($event)" @select="mySelectEventSignatory1($event)" />
                    <div v-if="errors.bank_list" class="invalid-feedback">{{ errors.bank_list[0] }}</div>
                </div>
            </div>
        </div>

         <div class="row mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary btn-block" @click.prevent="companyUpdate">Publish</button>
            </div>
        </div>

    </div>
</template>

<script>
import Select2 from 'v-select2-component';

export default {

    props: ['companyid'],

    components: {
        Select2,
    },

    data() {
        return {
            toEdit: {},
            errors: [],
            banks: [],
            signatories: [],
            signatories2: [],
            loading: false,
            signatory1: [],
            signatory2: [],
            selectedBank: [],
         }
    },

    mounted() {
        this.getCurrentCompany()
        this.getSignatories()
        this.getBank()
    },

    methods: {

        getBank() {
            axios.get('/getBanks')
            .then(response => {
                const filtered = response.data.map(({ id, name, branch }) => ({ id: id, text: `${name} - ${branch}` }))
                return Promise.resolve(filtered)
                .then(result => {
                    this.banks = result
                })
            })
        },

        getSignatories() {
            axios.get('/getSignatories')
            .then(response  => {
               const filtered = response.data.map(({ id, full_name }) => ({ id: id, text: full_name }))
               return Promise.resolve(filtered)
               .then(result => {
                   this.signatories = result
                   this.signatories2 = [...this.signatories]
               })
            });
        },

        getCurrentCompany() {
            axios.get(`/companies/${this.companyid}`)
            .then(response => {
                this.toEdit = response.data
                 if(response.data.signatories.length != 0) {
                    this.signatory1 = response.data.signatories.filter(item => item.policy_type === 1).map(item => item.id);
                    this.signatory2 = response.data.signatories.filter(item => item.policy_type === 2).map(item => item.id);
                }
                if(response.data.banks.length != 0) {
                    this.selectedBank = response.data.banks.map(item => item.id);
                }
            })
        },

        companyUpdate() {
            console.log('to Edit: ', this.toEdit.name)
            axios.put(`/companies/${this.companyid }`, {
                name: this.toEdit.name,
                department: this.toEdit.department,
                abbrv: this.toEdit.abbrv,
                signatory1: this.signatory1,
                signatory2: this.signatory2,
                bank_list: this.selectedBank
            })
            .then(response => {
                if(response.status == 200) {
                    // console.log('check result: ', response.data.data)
                    window.location = response.data.redirect;
                }
            })
            .catch(error => {
                if(error.response.status == 422) {
                    this.errors = error.response.data.errors
                }
            })
        },

        myChangeEventSignatory1(val){
            // console.log('selected value: ', this.signatory1);
            // console.log('selected value: ', val);
        },

        mySelectEventSignatory1({id, text}) {

            console.log({id, text})

            // let selectedObject = {id, text};
            // let index = this.signatories.findIndex(item => item.id === Number.parseInt(selectedObject.id));

            // let checkIfExisitng = this.signatories2.some(item => item.id === Number.parseInt(selectedObject.id))
            // console.log('check existing: ', checkIfExisitng)
            // console.log('check index: ', index)

            // if(!checkIfExisitng) {
            //     return this.signatories2.unshift(selectedObject)
            // }
        //    this.signatories2.splice(index,1);

        },

        myChangeEventSignatory2(val) {
            console.log(val);
            console.log('signatory 2: ', this.signatory2);
        },

        mySelectEventSignatory2({id, text}) {
            console.log({id, text})
            console.log('signatory 2: ', this.signatory2);
        }

    }

}
</script>

