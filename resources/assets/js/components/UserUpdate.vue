<template>
    <div>

        <div class="content-header mb-3">
            <div class="row">
            <div class="col">
                <span class="h3 text-dark">Update User:</span>
                <button type="button" class="float-right btn btn-primary"  @click="bankToUser">
                   <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to user list
                </button>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

        <div class="row">
            <div class="col">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" id="name" v-model="user.name" placeholder="Enter Name">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="email" v-model="user.email" placeholder="Enter Email">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" v-model="password" placeholder="Enter Password">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" v-model="selectedRole">
                        <option value="" selected>All Roles</option>
                        <option v-for="(role,i) in roles" :key="i" :value="role.id">{{ role.name }}</option>
                    </select>
                </div>

            </div>
        </div>


        <div class="row mt-3 mb-3">
            <div class="col">

                <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Custom Permission
                        </button>
                    </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h4">Role's Permission</span>
                                <span v-for="(permission, p) in userDefaultPermissions" :key="p">
                                    <div class="column-items">
                                    <label class="switch mt-2">
                                        <input type="checkbox" checked disabled>
                                        <span class="slider round"></span>
                                    </label> 
                                    <span class="ml-3">{{ permission.name }}</span>
                                    </div>
                                </span>
                            </div>
                            <div class="col">
                                <span class="h4">All Permissions</span>
                                <span v-for="(permission, index) in filterPermissions" :key="index">
                                    <div class="column-items">
                                    <label class="switch mt-2">
                                        <input type="checkbox" :checked="userPermissions(permission.id)" @click="syncOrDetach(permission.id)">
                                        <span class="slider round"></span>
                                    </label> 
                                    <span class="ml-3">{{ permission.name }}</span>
                                    </div>
                                </span>
                            </div>
                        </div>

                    </div>
                    </div>
                </div>
                </div>

            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <button class="btn btn-primary btn-block" :disabled="validateFields" @click.prevent="updateUser">
                    Update
                </button>
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

    props: ['user_id'],

    data() {
        return {
            user: [],
            roles: [],
            edit: true,
            permissions: [],
            detachPermissions: [],   
            name: '',
            email: '',
            password: '',
            selectedRole: '',
            selectedPermissions: [],
        }
    },

    watch: {
        selectedPermissions() {
            console.log(this.selectedPermissions)
        }
    },
    
    created() {
        this.getUser()
        this.getRoles()
        this.getPermissions()
    },

    methods: {

        bankToUser() {
            this.edit = false;
            this.$emit('backToUser', this.edit);
        },
        
        getUser() {
            axios.get('/users/' + this.user_id)
            .then(response => this.user = response.data);
        },

        updateUser() {
            axios.patch('/users/' + this.user_id, {
                name : this.user.name,
                email: this.user.email,
                password: this.password,
                role_list: this.selectedRole,
                attach_perm : this.getCurrentPerm,
                detach_perm : this.detachPermissions,
            })
            .then(response => {
                window.location = response.data.redirect;
                Vue.toasted.show("Updated Successfully!", { 
                    theme: "primary", 
                    position: "bottom-right", 
                    duration : 5000
                });
            })
            .catch((error) => {
                console.log(error);
            });
            
        },

        getPermissions() {
            axios.get('/getPermissions')
            .then(response => this.permissions = response.data);
        },

        getRoles() {
            axios.get('/getRoles')
            .then(response => this.roles = response.data);
        },

        // updatePermissions(permission) {
        //     var final;
        //     let getperm = this.selectedPermissions.indexOf(permission)
        //     if(getperm > -1) {
        //         final = this.selectedPermissions.splice(this.selectedPermissions.indexOf(permission), 1)
        //     } else {
        //          final = this.selectedPermissions.push(permission); 
        //     }
        //     return final;
        // },

        userPermissions(perm) {
            return this.user.user_permissions.some(x => x.id == perm);
        },

        syncOrDetach(perm) {

            var checkPerm = this.userPermissions(perm);
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

    },

    computed: {
        validateFields() {
            return this.user.name == '' ||
                    this.user.email == '';
        },

        roleId() {
            if(this.user.roles) {
                var pass = this.user.roles.map(x => x.id)[0];
                return this.selectedRole = pass;
            }
        },

        userDefaultPermissions() {
            try {
               return this.roles.find(role => role.id == this.roleId).permissions;
            } catch (e) {
                console.log(e)
            }
        },

        filterPermissions() {
            return this.permissions.filter((x,index) => {
                return !this.userDefaultPermissions.find(y => y.id == x.id);
            });

        },

        getCurrentPerm() {
            if(this.user.user_permissions) {
                return this.user.user_permissions.map(x => x.id);
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
