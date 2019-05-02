<template>
    <div>

    <div v-if="!edit">
        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Users</span>
                <button type="button" class="float-right btn btn-primary"  data-toggle="modal" data-target="#newUser">
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
        <div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="newUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" v-model="name" placeholder="Enter Name">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="email" v-model="email" placeholder="Enter Email">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" v-model="password" placeholder="Enter Password">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="validateFields" @click.prevent="storeUser" data-dismiss="modal">Submit</button>
            </div>
            </div>
        </div>
        </div>
    </div><!-- end users list -->


    <user-update :user_id="selectedUser" @backToUser="edit = $event" v-else></user-update>


    </div><!-- end template -->
</template>
<script>

import Toasted from 'vue-toasted';
import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';
import UserUpdate from './UserUpdate.vue';

Vue.use(Toasted)

export default {

    components: {
        UserUpdate
    },

    data() {
        return {
            loading: false,
            users: [],
            edit: false,
            selectedUser: '',
            name: '',
            email: '',
            password: '',
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getUsers()
    },

    methods: {

        resetFields() {
            this.name = '';
            this.email = '';
            this.password = '';
        },

        editUser(user) {
            this.edit = true;
            this.selectedUser = user.id;
        },

        getUsers() {
            this.loading = true
            axios.get('/getUsers')
            .then(response => {
                this.users = response.data
                this.loading = false
            });
        },

        storeUser() {
            axios.post('/users', {
                name : this.name,
                email : this.email,
                password: this.password
            })
            .then(response => {
                this.users.unshift(response.data)
                console.log('check response user: ', reponse.data)
                Vue.toasted.show("Added Successfully!", {
                    theme: "primary",
                    position: "bottom-right",
                    duration : 5000
                });
            })
            .catch(error => {
                console.log('error console: ', error)
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
                    this.email == '' ||
                    this.password == '';
        },

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

