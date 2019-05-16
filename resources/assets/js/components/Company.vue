<template>
    <div>

        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Companies</span>
                <button type="button" class="float-right btn btn-primary"  data-toggle="modal" data-target="#newCompany">
                    Add Company
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="search" placeholder="Search Company">
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-dark" >Avatar</th>
                    <th scope="col" class="text-dark" >Company</th>
                    <th scope="col" class="text-dark" >Division</th>
                    <th scope="col" class="text-dark" >Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(company,c) in filteredQueues" :key="c" v-if="!loading">
                    <td>
                        <img :src="avatar_link + company.avatar" class="img-responsive" style="height: 60px; width: auto;"  align="middle">
                    </td>
                    <td>{{ company.name }}</td>
                    <td>{{ company.department }}</td>
                    <td>
                          <!-- Default dropleft button -->
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" :href="`/companies/${company.id}/edit`">Edit</a>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                        </div>
                    </td>
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
                <span>{{ companies.length }} Companies</span>
            </div>
        </div>


        <!-- Add New Bank Modal -->
        <div class="modal fade" id="newCompany" tabindex="-1" role="dialog" aria-labelledby="newCompanyLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCompanyLabel">Add New Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" class="form-control"  v-model="name" placeholder="Enter Company Name">
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <input type="text" class="form-control"  v-model="department" placeholder="Enter Department">
                </div>

                <div class="form-group">
                    <label>Abbrv</label>
                    <input type="text" class="form-control"  v-model="abbrv" placeholder="Enter Abbreviation">
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="validateFields" @click.prevent="storeCompany" data-dismiss="modal">Submit</button>
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
            companies: [],
            avatar_link: '/storage/',
            avatar: 'companies/avatar.png',
            name: '',
            department: '',
            abbrv: '',
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getCompanies()
    },

    methods: {
        resetFields() {
            this.name = '';
            this.department = '';
            this.abbrv = '';
        },

        getCompanies() {
            axios.get('/getCompanies')
            .then(response => this.companies = response.data)
        },

        storeCompany() {
            axios.post('/companies', {
                name : this.name,
                department : this.department,
                abbrv : this.abbrv,
                avatar : this.avatar
            })
            .then(response => {
                this.companies.unshift(response.data)
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
            return this.name == '' ||
                    this.department == '' ||
                    this.abbrv == '';
        },

        filteredEntries() {
            return this.companies.filter(item => {
                return item.name.toLowerCase().includes(this.search.toLowerCase());
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
