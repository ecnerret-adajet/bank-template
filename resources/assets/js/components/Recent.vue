<template>
<div>
        <div class="row">
        <div class="col" v-if="recents.recent_banktransfer != 0">
            <span class="h4 text-muted">
                Bank Transfer
            </span>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Ref Number</th>
                        <th>Date</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(bt,b) in recents.recent_banktransfer" :key="b">
                        <td>{{ bt.ref_num }}</td>
                        <td>{{ date(bt.created_at.date) }}</td>
                        <td>
                            <a :href="'/bank-transfers/pdf/' + bt.id" target="_blank" class="btn btn-primary btn-sm" >View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
         <div class="col" v-if="recents.recent_manager_checks != 0">
            <span class="h4 text-muted">
                Manager's Check
            </span>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Ref Number</th>
                        <th>Date</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(mc,b) in recents.recent_manager_checks" :key="b">
                        <td>{{ mc.ref_num }}</td>
                        <td>{{ date(mc.created_at.date) }}</td>
                        <td>
                            <a :href="'/manager-checks/pdf/' + mc.id" target="_blank" class="btn btn-primary btn-sm" >View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col" v-if="recents.recent_payrolls != 0">
            <span class="h4 text-muted">
                Manager's Check
            </span>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Ref Number</th>
                        <th>Application Type</th>
                        <th>Date</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(payroll,b) in recents.recent_payrolls" :key="b">
                        <td>{{ payroll.ref_num }}</td>
                        <td>{{ payroll.type }}</td>
                        <td>{{ date(payroll.created_at.date) }}</td>
                        <td>
                            <a :href="'/payrolls/pdf/' + payroll.id" target="_blank" class="btn btn-primary btn-sm" >View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
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
    
    data() {
       return {
           loading: false,
           recents: []
       }
    },

    created() {
        this.getRecentSubmitted()
    },

    methods: {
        getRecentSubmitted() {
            this.loading = true
            axios.get('/recentSubmitted')
            .then(response => {
                this.recents = response.data
                this.loading  = false
            });
        },

        date(date) {
            return moment(date).format('YYYY-MM-DD');
        },
    }




}
</script>
