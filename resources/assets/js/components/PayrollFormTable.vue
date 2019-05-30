<template>
    <div>
        <p>Applicants Table</p>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                <th scope="col">Employee Name</th>
                <th scope="col">Branch</th>
                <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
        <tr v-for="(applicant, index) in applicants" :key="index">
            <td>
                <div v-if="applicant.status == 0" @dblclick="editItem(applicant)">{{ applicant.name }}</div>
                <input v-if="applicant.status == 1" type="text" class="form-control" v-model="applicant.name" v-focus>
            </td>
            <td>
                <div v-if="applicant.status == 0" @dblclick="editItem(applicant)">{{ applicant.branch }}</div>
                <select v-else class="form-control" v-model="applicant.branch" v-focus>
                    <option value="" disabled selected>Select Branch</option>
                    <option v-for="(bank,i) in banks" :key="i" selected :value="bank.branch">{{ bank.branch }}</option>
                </select>
            </td>
            <td>
                 <button v-if="applicant.status == 0" type="button" class="btn btn-primary btn-block" @click="removeItem(applicant)">Delete</button>
                 <button v-else type="button" class="btn btn-primary btn-block" @click="updateItem(applicant)">Update</button>
            </td>
        </tr>

        <tr>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control" id="name" v-model="name" placeholder="Enter Name">
                </div>
            </td>
            <td>
                 <div class="form-group">
                     <select class="form-control" v-model="branch" v-focus>
                         <option value="" disabled selected>Select Branch</option>
                        <option v-for="(bank,i) in banks" :key="i" selected :value="bank.branch">{{ bank.branch }}</option>
                    </select>
                </div>
            </td>
            <td>
                <button type="button"  class="btn btn-primary btn-block" :disabled="!allowToSubmit" @click.prevent="addItem">Add</button>
            </td>
        </tr>
         </tbody>
    </table>

    </div>
</template>
<script>
export default {
    props: ['user_id'],

    props: {
        'user_id': String,
        'banks': Array
    },

    data() {
        return {
            name: '',
            branch: '',
            applicants: [],
            beforeEditCache: {
                name: '',
                company: '',
                branch: ''
            }
        }
    },

    directives: {
        focus: {
            // directive definition
            inserted: function(el) {
                el.focus()
            }
        }
    },

    created() {
        this.getApplicants()
        // this.getBanks()
    },

    methods: {
        getApplicants() {
            axios.get('/applicants')
            .then(response => this.applicants = response.data);
        },

        resetFields() {
            this.name = '';
            this.branch = '';
        },

        // getBanks() {
        //     axios.get('/getBanks')
        //     .then(response => this.banks = response.data);
        // },

        addItem() {
            axios.post('/applicants/' + this.user_id, {
                name: this.name,
                branch: this.branch,
                status: 0,
            })
            .then(response => {
                console.log(response.data);
                this.applicants.push(response.data);
            })
            .catch((error) => {
                console.log(error);
            });

            this.resetFields();
        },

        removeItem(applicant) {
            axios.delete('/applicants/' + applicant.id)
            .then(response => {
                this.applicants.splice(this.applicants.indexOf(applicant), 1)
            })
            .catch((error) => {
                console.log(error);
            });
        }

    },

    computed: {
        allowToSubmit() {
            return this.name.trim().length > 0 &&
                   this.branch.trim().length > 0;
        }
    }


}
</script>

