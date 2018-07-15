<template>
    <div>


        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Permissions</span>
                <button type="button" class="float-right btn btn-primary"  data-toggle="modal" data-target="#newPermission">
                    Add Permission
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="search" placeholder="Search Permission">
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col" class="text-dark" >Name</th>
                <th scope="col" class="text-dark" >Description</th>
                <th scope="col" class="text-dark" >Role</th>
                <th scope="col" class="text-dark" >Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(permission, b) in filteredQueues" :key="b" v-if="!loading">
                    <td>{{ permission.name }}</td>
                    <td>{{ permission.description }}</td>
                    <td>
                        <span v-for="(role,r) in permission.roles" :key="r">
                            {{ role.name }} <br/>
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-info btn-sm" href="#">
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
                <span>{{ permissions.length }} Bank(s)</span>
            </div>
        </div>


        <!-- Add New Bank Modal -->
        <div class="modal fade" id="newPermission" tabindex="-1" role="dialog" aria-labelledby="newPermissionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPermissionLabel">Add New Permission</h5>
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
                    <label>Slug</label>
                    <input type="text" class="form-control" id="slug" v-model="slug" placeholder="Enter Email">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea rows="3" class="form-control" id="description" v-model="description" placeholder="Enter Description">
                    </textarea>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="validateFields" @click.prevent="storePermission" data-dismiss="modal">Submit</button>            
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
            permissions: [],
            roles: [],
            name: '',
            slug: '',
            description: '',
            model: 'Permission',
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getPermissions()
        this.getRoles()
    },

    methods: {

        resetFields() {
            this.name = '';
            this.slug = '',
            this.description = '';
        },

        getRoles() {
            axios.get('/getRoles')
            .then(response => this.roles = response.data)
        },

        getPermissions() { 
            this.loading = true
            axios.get('/getPermissions')
            .then(response => {
                this.permissions = response.data
                this.loading = false
            });
        },

        storePermission() {
            axios.post('/permissions', {
                name: this.name,
                slug: this.slug,
                description: this.description
            })
            .then(response => {
                this.permissions.unshift(response.data)
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
                    this.slug == '' ||
                    this.description == '';
        },

        filteredEntries() {
            return this.permissions.filter(item => {
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
