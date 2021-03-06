<template>
    <div>

    <div v-if="!edit">
        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Users</span>
                <button type="button" class="float-right btn btn-primary"  @click="openCreateModal()">
                    Add User
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="search" placeholder="Search User">
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col" class="text-dark" >Name</th>
                <th scope="col" class="text-dark" >Email</th>
                <th scope="col" class="text-dark" >Role</th>
                <th scope="col" class="text-dark" >Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, b) in filteredQueues" :key="b" v-if="!loading">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <span v-for="(role, r) in user.roles" :key="r">
                            {{ role.name  }} <br/>
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-info btn-sm" @click="editUser(user)" href="javascript:void(0);">
                            Update
                        </a>
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
                <span>{{ users.length }} Bank(s)</span>
            </div>
        </div>


        <!-- Add New Bank Modal -->
        <user-form :showModal="showModal"
                    :is-create="isCreate"
                    :to-edit="toEdit"
                    @editResponse="editResponse"
                    @returnToEdit="toEdit = $event"
                    @returnShowModal="showModal = $event"
                    @storeResponse="storeResponse">
        </user-form>



    </div><!-- end users list -->


    <user-update :to-edit="toEdit"
                :user_id="selectedUser"
                @backToUser="edit = $event" v-else></user-update>


    </div><!-- end template -->
</template>
<script>

import Toasted from 'vue-toasted';
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';
import UserUpdate from './UserUpdate.vue';
import Form from './users/Form.vue';

Vue.use(Toasted)

export default {

    components: {
        VueContentPlaceholders,
        UserUpdate,
        userForm: Form
    },

    data() {
        return {
            loading: false,
            users: [],
            toEdit: {},
            toDelete: {},
            edit: false,
            showModalDelete: false,
            isCreate: false,
            showModal: false,
            selectedUser: '',
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getUsers()
    },

    methods: {

        editResponse(event) {
            let findIndex = this.users.findIndex(item => item.id === event.id);
            return this.users[findIndex] = event;
        },

        editUser(user) {
            this.edit = true;
            this.selectedUser = user.id;
            this.toEdit = user;
        },

        storeResponse(event) {
            return this.users.unshift(event)
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

        getUsers() {
            this.loading = true
            axios.get('/getUsers')
            .then(response => {
                this.users = response.data
                this.loading = false
            });
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
            return this.users.filter(item => {
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

