<template>
    <div>


        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Managers</span>
                <button type="button" class="float-right btn btn-primary"  data-toggle="modal" data-target="#newManager">
                    Add New Manager
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="search" placeholder="Search Manager">
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col" class="text-dark" >Full Name</th>
                <th scope="col" class="text-dark" >Bank</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(manager, m) in filteredQueues" :key="m" v-if="!loading">
                    <td>{{ manager.full_name }}</td>
                    <td>{{ manager.bank }}</td>
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
                <span>{{ managers.length }} Manager(s)</span>
            </div>
        </div>


        <!-- Add New Bank Modal -->
        <div class="modal fade" id="newManager" tabindex="-1" role="dialog" aria-labelledby="newManagerLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newManagerLabel">Add New Manager</h5>
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
                    <label>Title</label>
                    <select class="form-control" v-model="title">
                        <option value=""  selected>Select Title</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Mr.">Mr.</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" id="name" v-model="first_name" placeholder="Enter First Name">
                </div>

                <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" id="name" v-model="middle_name" placeholder="Enter Middle Name">
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" id="name" v-model="last_name" placeholder="Enter Last Name">
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="validateFields" @click.prevent="storeManager" data-dismiss="modal">Submit</button>            
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
            managers: [],
            banks: [],
            selectedBank: '',
            title: '',
            first_name: '',
            middle_name: '',
            last_name: '',
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getManagers()
        this.getBanks()
    },

    methods: {

        resetFields() {
            this.title = '';
            this.first_name = '';
            this.middle_name = '';
            this.last_name = '';
        },

        getBanks() {
            axios.get('/getBanks')
            .then(response => this.banks = response.data);
        },

        getManagers() {
            this.loading = true
            axios.get('/getManagers')
            .then(response => {
                this.managers = response.data
                this.loading = false
            });
        },

        storeManager() {
            axios.post('/managers', {
                bank_list: this.selectedBank,
                title : this.title,
                first_name : this.first_name,
                middle_name: this.middle_name,
                last_name: this.last_name
            })
            .then(response => {
                this.managers.unshift(response.data)
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
                    this.title == '' ||
                    this.first_name == '' ||
                    this.middle_name == '' ||
                    this.last_name == '';
        },

        filteredEntries() {
            return this.managers.filter(item => {
                return item.full_name.toLowerCase().includes(this.search.toLowerCase());
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
