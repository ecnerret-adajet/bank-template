<template>
    <div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active text-uppercase" @click="selected = 1" data-toggle="tab" href="#bank-transfer">Bank Transfer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" @click="selected = 2" data-toggle="tab" href="#manager-check">Manager Check</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" @click="selected = 3" data-toggle="tab" href="#payroll">Payroll</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade show active pt-5" id="bank-transfer">
                <bank-transfer-submitted v-if="selected == 1"></bank-transfer-submitted>
            </div>
            <div class="tab-pane fade pt-5" id="manager-check">
                <manager-check-submitted v-if="selected == 2"></manager-check-submitted>
            </div>
            <div class="tab-pane fade pt-5" id="payroll">
                <payroll-submitted v-if="selected == 3"></payroll-submitted>
            </div>
        </div>

    </div>
</template>
<script>
import BankTransferSubmitted from './BankTransferSubmitted.vue';
import ManagerCheckSubmitted from './ManagerCheckSubmitted.vue';
import PayrollSubmitted from './PayrollSubmitted.vue';

export default {
    
    data() {
        return {
            selected: 1
        }
    },

    components: {
        BankTransferSubmitted,
        ManagerCheckSubmitted,
        PayrollSubmitted
    }


}
</script>
