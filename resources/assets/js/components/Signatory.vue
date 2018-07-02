<template>
    <div>

        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Signatories</span>
                <button type="button" class="float-right btn btn-primary"  data-toggle="modal" data-target="#newSignatory">
                    Add Signatories
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="search" placeholder="Search Signatory">
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col" class="text-dark" >Name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(signatory,s) in filteredQueues" :key="s" v-if="!loading">
                    <td>{{ signatory.full_name }}</td>
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
                <span>{{ signatories.length }} Signatories</span>
            </div>
        </div>


        <!-- Add New Bank Modal -->
        <div class="modal fade" id="newSignatory" tabindex="-1" role="dialog" aria-labelledby="newSignatoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSignatoryLabel">Add New Signatory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control"  v-model="first_name" placeholder="Enter First Name">
                </div>

                <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" class="form-control"  v-model="middle_name" placeholder="Enter Middle Name">
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control"  v-model="last_name" placeholder="Enter Last Name">
                </div>

            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="validateFields" @click.prevent="storeSignatory" data-dismiss="modal">Submit</button>            
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
            signatories: [],
            first_name: '',
            middle_name: '',
            last_name: '',
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getSignatories()
    },

    methods: {
        resetFields() {
            this.first_name = '';
            this.middle_name = '';
            this.last_name = '';
        },

        getSignatories() {
            axios.get('/getSignatories')
            .then(response => this.signatories = response.data)
        },

        storeSignatory() {
            axios.post('/signatories', {
                first_name: this.first_name,
                middle_name: this.middle_name,
                last_name: this.last_name
            })
            .then(response => {
                this.signatories.unshift(response.data)
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
            return this.first_name == '' ||
                    this.middle_name == '' ||
                    this.last_name == '';
        },

        filteredEntries() {
            return this.signatories.filter(item => {
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
