<template>
    <div>

        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Signatories</span>
                <button type="button" class="float-right btn btn-primary" @click="openCreateModal()">
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
                <th scope="col" class="text-dark" >Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(signatory,s) in filteredQueues" :key="s" v-if="!loading">
                    <td>{{ signatory.full_name }}</td>
                    <td>
                        <!-- Default dropleft button -->
                        <div class="btn-group dropleft">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" @click="openEditModal(signatory)">Edit</a>
                            <a class="dropdown-item text-danger" @click="openDeleteModal(signatory)">Delete</a>
                        </div>
                        </div>
                    </td>
                </tr>
                <tr v-if="filteredQueues.length == 0 && !loading">
                    <td colspan="2" class="text-center" >
                        <h3>Nothing found</h3>
                    </td>
                </tr>
                <tr v-if="loading">
                    <td colspan="2">
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
                <span>{{ signatories.length }} Signatories</span>
            </div>
        </div>


        <!-- Add New Bank Modal -->
        <signatory-form :showModal="showModal"
                    :is-create="isCreate"
                    :to-edit="toEdit"
                    @editResponse="editResponse"
                    @returnToEdit="toEdit = $event"
                    @returnShowModal="showModal = $event"
                    @storeResponse="storeResponse">
        </signatory-form>

        <!-- Delete Module -->
        <signatory-delete :showModalDelete="showModalDelete"
                    :to-delete="toDelete"
                    @returnShowModalDelete="showModalDelete = $event"
                    @deleteResponse="deleteResponse"></signatory-delete>


    </div>
</template>
<script>

import Toasted from 'vue-toasted';
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';
import Form from './signatories/Form.vue';
import Delete from './signatories/Delete.vue';

Vue.use(Toasted)

export default {

    components: {
        VueContentPlaceholders,
        signatoryForm: Form,
        signatoryDelete: Delete
    },

    data() {
        return {
            loading: false,
            signatories: [],
            toEdit: {},
            toDelete: {},
            showModalDelete: false,
            isCreate: false,
            showModal: false,
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getSignatories()
    },

    methods: {

        editResponse(event) {
            // let findIndex = this.signatories.findIndex(item => item.id === event.id);
            // return this.signatories[findIndex] = event;
            this.getSignatories()
        },

        deleteResponse(event) {
             let findIndex = this.signatories.findIndex(item => item.id === event.id);
             return Promise.resolve(findIndex)
             .then(result => {
                  this.signatories.splice(result, 1);
                  this.resetRow()
             })
        },

        storeResponse(event) {
            return this.signatories.unshift(event)
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

        openDeleteModal(object) {
            this.showModalDelete = !this.showModalDelete
            if(this.showModalDelete) {
                this.toDelete = object
            }
        },

        getSignatories() {
            this.loading = true
            axios.get('/getSignatories')
            .then(response => {
                this.signatories = response.data
                this.loading = false
            })
        },

        setPage(pageNumber) {
            this.currentPage = pageNumber;
        },

        resetRow() {
            if(this.currentPage >= this.totalPages) {
                this.currentPage = this.totalPages - 1
            }

            if(this.currentPage == -1) {
                this.currentPage = 0;
            }
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
