<template>
    <div>

        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Banks</span>
                <button type="button" class="float-right btn btn-primary" @click="openCreateModal()">
                    Add New Bank
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="search" placeholder="Search Bank">
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col" class="text-dark" >Name</th>
                <th scope="col" class="text-dark" >Branch</th>
                <th scope="col" class="text-dark" >Location</th>
                <th scope="col" class="text-dark" >Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(bank, b) in filteredQueues" :key="b" v-if="!loading">
                    <td>{{ bank.name }}</td>
                    <td>{{ bank.branch }}</td>
                    <td>{{ bank.location }}</td>
                    <td>
                        <!-- Default dropleft button -->
                        <div class="btn-group dropleft">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" @click="openEditModal(bank)">Edit</a>
                            <a class="dropdown-item text-danger" href="#">Delete</a>
                        </div>
                        </div>
                    </td>
                </tr>
                <tr v-if="filteredQueues.length == 0 && !loading">
                    <td colspan="4" class="text-center" >
                        <h3>Nothing found</h3>
                    </td>
                </tr>
                <tr v-if="loading">
                    <td colspan="4">
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
                <span>{{ banks.length }} Bank(s)</span>
            </div>
        </div>


        <bank-form :showModal="showModal"
                    :is-create="isCreate"
                    :to-edit="toEdit"
                    @editResponse="editResponse"
                    @returnToEdit="toEdit = $event"
                    @returnShowModal="showModal = $event"
                    @storeResponse="storeResponse">
        </bank-form>



        <!-- Add New Bank Modal -->
        <!-- <div class="modal fade" id="newBank" tabindex="-1" role="dialog" aria-labelledby="newBankLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newBankLabel">Add New Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group" :class="{ ' has-danger' : errors.name }">
                    <label>Bank Name</label>
                    <input type="text" class="form-control" id="name" v-model="name" :class="{ 'is-invalid' : errors.name }" placeholder="Enter Name">
                    <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                </div>

                 <div class="form-group" :class="{ ' has-danger' : errors.branch }">
                    <label>Branch</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.branch }" v-model="branch" placeholder="Enter Branch">
                    <div v-if="errors.branch" class="invalid-feedback">{{ errors.branch[0] }}</div>
                </div>

                <div class="form-group" :class="{ ' has-danger' : errors.location }">
                    <label>Location</label>
                    <input type="text" class="form-control" id="name" :class="{ 'is-invalid' : errors.location }" v-model="location" placeholder="Enter Location">
                    <div v-if="errors.location" class="invalid-feedback">{{ errors.location[0] }}</div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="validateFields" @click.prevent="storeBank" data-dismiss="modal">Submit</button>
            </div>
            </div>
        </div>
        </div> -->

    </div>
</template>
<script>

import Toasted from 'vue-toasted';
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';
import Form from './banks/Form.vue';

Vue.use(Toasted)

export default {

    components: {
        VueContentPlaceholders,
        bankForm: Form,
    },

    data() {
        return {
            loading: false,
            banks: [],
            toEdit: {},
            isCreate: false,
            showModal: false,
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getBanks()
    },

    methods: {

        editResponse(event) {
            let findIndex = this.banks.findIndex(item => item.id === event.id);
            return this.banks[findIndex] = event;
        },

        storeResponse(event) {
            return this.banks.unshift(event)
        },

        openCreateModal() {
            this.showModal = true;
            this.isCreate = true;
        },

        openEditModal(object) {
            this.showModal = !this.showModal;
            this.isCreate = false;
            if(this.showModal) {
                this.toEdit = object
            }
        },

        resetFields() {
            this.name = '';
            this.branch = '';
            this.location = '';
        },

        getBanks() {
            this.loading = true
            axios.get('/getBanks')
            .then(response => {
                this.banks = response.data
                this.loading = false
            });
        },

        returnMessage(message) {
            Vue.toasted.show(message, {
                theme: "primary",
                position: "bottom-right",
                duration : 5000
            });
        },

        storeBank() {
            axios.post('/banks', {
                name : this.name,
                branch : this.branch,
                location: this.location
            })
            .then(response => {
                if(response.status === 200) {
                    this.banks.unshift(response.data)
                    this.returnMessage("Added successfully!")
                    this.resetFields()
                }
            })
            .catch(error => {
                if(error.response.status == 422) {
                    this.errors = error.response.data.errors
                }
            });
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
                    this.branch == '' ||
                    this.location == '';
        },

        filteredEntries() {
            return this.banks.filter(item => {
                return item.name.toLowerCase().includes(this.search.toLowerCase()) ||
                       item.branch.toLowerCase().includes(this.search.toLowerCase()) ||
                       item.location.toLowerCase().includes(this.search.toLowerCase());
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
<style scoped>
    .dropdown-menu button {
        cursor: pointer;
    }

    .column-items {
        display: flex;
        align-items: center;
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

</style>
