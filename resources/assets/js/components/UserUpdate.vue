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
                    <select class="form-control" v-model="userRole">
                        <option value="" selected>All Roles</option>
                        <option v-for="(role,i) in roles" :key="i" :value="role.id">{{ role.name }}</option>
                    </select>
                </div>

            </div>
        </div>


        <!-- <div class="row">
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
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                    </div>
                </div>
                </div>

            </div>
        </div> -->

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
            name: '',
            email: '',
            password: '',
            selectedRole: '',
            selectedPermissions: [],
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
                role_list: this.userRole
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
        }

    },

    computed: {
        validateFields() {
            return this.user.name == '' ||
                    this.user.email == '';
        },

        userRole() {
            if(this.user.roles) {
                return this.user.roles.map(x => x.id)[0];
            }
        }
    }


}
</script>
