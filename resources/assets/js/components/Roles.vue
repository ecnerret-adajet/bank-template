<template>
    <div>

        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">All Roles</span>
                <button type="button" class="float-right btn btn-primary"  data-toggle="modal" data-target="#newRole">
                    Add Role
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="search" placeholder="Search Roles">
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col" class="text-dark" >Name</th>
                <th scope="col" class="text-dark" >Description</th>
                <th scope="col" class="text-dark" >Permissions</th>
                <th scope="col" class="text-dark" >Level</th>
                <th scope="col" class="text-dark" >Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(role, b) in filteredQueues" :key="b" v-if="!loading">
                    <td>{{ role.name }}</td>
                    <td>{{ role.description }}</td>
                    <td>
                        {{ role.permissions.length }} 
                    </td>
                    <td>
                        {{ role.level }} 
                    </td>
                    <td>
                        <a class="btn btn-info btn-sm" href="javascript:void(0);" @click="getCurrentRole(role)" data-toggle="modal" :data-target="'#updateRole-' + role.id">
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
                <span>{{ roles.length }} Bank(s)</span>
            </div>
        </div>


        <!-- Add New Role Modal -->
        <div class="modal fade" id="newRole" tabindex="-1" role="dialog" aria-labelledby="newRoleLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Add New Role</h5>
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
                    <label>Description</label>
                    <textarea rows="3" class="form-control" id="description" v-model="description" placeholder="Enter Description">
                    </textarea>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <input type="number" class="form-control" id="level" v-model="level" placeholder="Define level">
                </div>

                <div class="form-group">

                    <div div class="row">
                        <div class="col"  v-for="(x, p) in Math.ceil(permissions.length/6)" :key="p">
                              <div class="column-items" v-for="(perm, pe) in permissions.slice((x -1) * 6, x *6)" :key="pe">
                                <label class="switch mt-2">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                </label> 
                                <span class="ml-3">{{ perm.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="validateFields" @click.prevent="storeRoles" data-dismiss="modal">Submit</button>            
            </div>
            </div>
        </div>
        </div>
        <!-- end add new roles modal -->


        <!-- Update Role Modal -->
        <div class="modal fade" v-for="(role,r) in filteredQueues" :key="r" :id="'updateRole-'+role.id" tabindex="-1" role="dialog" aria-labelledby="updateRoleLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateRoleLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{ getCurrentPerm }}
                
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" v-model="role.name" placeholder="Enter Name">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea rows="3" class="form-control" id="description" v-model="role.description" placeholder="Enter Description">
                    </textarea>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <input type="number" class="form-control" id="level" v-model="role.level" placeholder="Define level">
                </div>

                <div class="form-group">
                    <div div class="row">
                        <div class="col"  v-for="(x, p) in Math.ceil(permissions.length/6)" :key="p">
                              <div class="column-items" v-for="(perm, pe) in permissions.slice((x -1) * 6, x *6)" :key="pe">
                                <label class="switch mt-2">
                                    <input type="checkbox" :checked="rolePermissions(role.id, perm.id)" @click="syncOrDetach(role.id,perm.id)">
                                    <span class="slider round"></span>
                                </label> 
                                <span class="ml-3">{{ perm.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary"  @click.prevent="updateRoles" data-dismiss="modal">Submit</button>            
            </div>
            </div>
        </div>
        </div>
        <!-- End Update Role Modal -->

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
            roles: [],
            permissions: [],
            detachPermissions: [],
            role: [],
            name: '',
            description: '',
            level: 1,
            search: '',
            currentPage: 0,
            itemsPerPage: 5,
        }
    },

    created() {
        this.getRoles()
        this.getPermissions()
    },

    watch: {
        detachPermissions() {
            console.log('detach = ' + this.detachPermissions)
        },

        role() {
            console.log(this.role)
        }
    },

    methods: {

        resetFields() {
            this.name = '';
            this.level = 1;
            this.description = '';
        },

        getRoles() { 
            this.loading = true
            axios.get('/getRoles')
            .then(response => {
                this.roles = response.data
                this.loading = false
            });
        },

        getPermissions() {
            axios.get('/getPermissions')
            .then(response => this.permissions = response.data);
        },

        storeRoles() {
            axios.post('/storeRoles', {
                name : this.name,
                description : this.description,
                level : this.level
            })
            .then(response => {
                this.roles.unshift(response.data)
                Vue.toasted.show("Added Successfully!", { 
                    theme: "primary", 
                    position: "bottom-right", 
                    duration : 5000
                });
            })
            this.resetFields()
        },

        updateRoles() {
            axios.patch('/updateRoles/' + this.role.id, {
                name: this.role.name,
                description: this.role.description,
                level: this.role.level,
                attach_list: this.getCurrentPerm,
                detach_list: this.detachPermissions
            })
            .then(response => {
                this.roles.unshift(response.data)
                Vue.toasted.show("Update Successfully!", { 
                    theme: "primary", 
                    position: "bottom-right", 
                    duration : 5000
                });
            })
        },

        getCurrentRole(role) {
            return this.role = role;
        },

        rolePermissions(role, perm) {
            var findRole = this.filteredQueues.find(x => x.id == role).permissions; // container
            return findRole.some(x => x.id == perm); // return boolean if find from container
        },

        syncOrDetach(role, perm) {

            var checkPerm = this.rolePermissions(role, perm);
            var final;

            let detachPerm = this.detachPermissions.indexOf(perm);
            let attachPerm = this.getCurrentPerm.indexOf(perm);

            if(checkPerm) {
                final = detachPerm > -1 ? this.detachPermissions.splice(this.detachPermissions.indexOf(perm), 1) : this.detachPermissions.push(perm);
            } else {                
                final = attachPerm > -1 ? this.getCurrentPerm.splice(this.getCurrentPerm.indexOf(perm), 1) : this.getCurrentPerm.push(perm);
            }
            return final;

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
                    this.description == '' ||
                    this.level == '';
        },

        filteredEntries() {
            return this.roles.filter(item => {
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
        },

        getCurrentPerm() {
            if(this.role.permissions) {
                return this.role.permissions.map(x => x.id);
            }
        }
    }
}
</script>
<style scoped>
    .column-items {
        display: flex;
        align-items: center;
    }
</style>