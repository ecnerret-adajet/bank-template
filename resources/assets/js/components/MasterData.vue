<template>
    <div class="row mt-4">

        <!-- sidebar -->
        <div class="col-3">

            <div class="list-group">
                <a href="javascript:void(0);" @click="selected = 1" class="list-group-item list-group-item-action" :class="{ active : selected == 1 }">
                    Bank
                </a>
                <a href="javascript:void(0);" @click="selected = 2" class="list-group-item list-group-item-action" :class="{ active : selected == 2 }">
                    Managers
                </a>
                <a href="javascript:void(0);" @click="selected = 3" class="list-group-item list-group-item-action" :class="{ active : selected == 3 }">
                    Account Numbers
                </a>
                <a href="javascript:void(0);" @click="selected = 4" class="list-group-item list-group-item-action" :class="{ active : selected == 4 }">
                    Company
                </a>
                <a href="javascript:void(0);" @click="selected = 5" class="list-group-item list-group-item-action" :class="{ active : selected == 5 }">
                    Signatories
                </a>
            </div>
            
        </div>

        <div class="col">

            <bank v-if="selected == 1"></bank>
            <manager v-if="selected == 2"></manager>
            <account v-if="selected == 3"></account>
            <company v-if="selected == 4"></company>
            <signatory v-if="selected == 5"></signatory>

        </div>

    </div>
</template>
<script>

import Bank from './Bank.vue';
import Manager from './Manager.vue';
import Account from './Account.vue';
import Company from './Company.vue';
import Signatory from './Signatory.vue';

export default {

    components: {
        Bank,
        Manager,
        Account,
        Company,
        Signatory
    },

    // created() {
    //     this.getBanks()
    //     this.getManagers()
    // }, 

    data() {
        return {
            selected: 1
        }
    }
}
</script>


