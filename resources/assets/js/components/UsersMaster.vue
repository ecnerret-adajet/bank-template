<template>
    <div class="row mt-4">

        <!-- sidebar -->
        <div class="col-3">

            <div class="list-group">
                <a href="javascript:void(0);" @click="selected = 1" class="list-group-item list-group-item-action" :class="{ active : selected == 1 }">
                    Users
                </a>
                <a href="javascript:void(0);" @click="selected = 2" class="list-group-item list-group-item-action" :class="{ active : selected == 2 }">
                    Permission
                </a>
                <a href="javascript:void(0);" @click="selected = 3" class="list-group-item list-group-item-action" :class="{ active : selected == 3 }">
                    Roles
                </a>
            </div>
            
        </div>

        <div class="col">


            <users v-if="selected == 1"></users>
            <permissions v-if="selected == 2"></permissions>
            <roles v-if="selected == 3"></roles>

       

        </div>

    </div>
</template>
<script>

import Users from './Users.vue';
import Permissions from './Permissions.vue';
import Roles from './Roles.vue';

export default {

    components: {
        Users,
        Permissions,
        Roles
    },

    data() {
        return {
            selected: 1
        }
    }
}
</script>


