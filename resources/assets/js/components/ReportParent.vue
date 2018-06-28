<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <select class="form-control" v-model="selected">
                        <option :value="1" selected>Bank Transfer</option>
                        <option :value="2" selected>Manager's Check</option>
                        <option :value="3" selected>Payroll Application</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">

                <app-bank-transfer-report v-if="selected == 1"></app-bank-transfer-report>
                <app-manager-check-report v-if="selected == 2"></app-manager-check-report>
                <app-payroll-application v-if="selected == 3"></app-payroll-application>

            </div>
        </div>
    </div>
</template>
<script>
import BankTransferReport from './BankTransferReport.vue';
import ManagerCheckReport from './ManagerCheckReport.vue';
import PayrollApplication from './PayrollApplicationReport.vue';

export default {
    
    data() {
        return {
            selected: 1
        }
    },

    components: {
        appBankTransferReport: BankTransferReport,
        appManagerCheckReport: ManagerCheckReport,
        appPayrollApplication: PayrollApplication,
    }


}
</script>
