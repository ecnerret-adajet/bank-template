<template>
    <div>

        <div class="row mb-2">
            <div class="col">
                <div class="form-group">
                    <label class="text-muted text-uppercase" >Filter by date</label>
                    <input class="form-control" type="date" v-model="date" :max="currentDate">
                </div>
            </div>
            <div class="col-2">
                <label>&nbsp;</label>
                <div class="form-group">
                    <div class="btn-group">
                    <button type="button" class="btn btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter Fields <i class="fa fa-2x fa-filter" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button v-for="(column, c) in columns" :key="c" @click="setVisibility(column)" class="dropdown-item column-items" type="button">
                            <label class="switch mt-2">
                                <input type="checkbox" @click="setVisibility(column)" v-model="column.visibility">
                                <span class="slider round"></span>
                            </label> 
                            <span class="ml-2">{{ column.name }}</span>
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <div class="form-group">
                    <select class="form-control" v-model="typeSearch">
                        <option value="" selected>All Payroll type</option>
                        <option value="ATM Application">ATM Application</option>
                        <option value="Delisting of Employee">Delisting of Employee</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <select class="form-control" v-model="companySearch">
                        <option value="" selected>All Companies</option>
                        <option v-for="(company,i) in companies" :key="i" selected :value="company.name">{{ company.name }}</option>
                    </select>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <th v-for="(column,c) in columns" v-show="column.visibility" :key="c">
                    {{ column.name }}    
                </th>
            </thead>
            <tbody>
                <tr v-for="(payroll, b) in filteredQueues" :key="b" v-if="!loading">
                    <td v-show="columns[0].visibility">{{ payroll.ref_num }}</td>
                    <td v-show="columns[1].visibility">{{ payroll.type }}</td>
                    <td v-show="columns[2].visibility">{{ payroll.company }}</td>
                    <td v-show="columns[3].visibility">{{ payroll.manager }}</td>
                    <td v-show="columns[4].visibility">{{ payroll.applicants.length }}</td>
                    <td v-show="columns[5].visibility">
                        <span v-for="(signatory, s) in payroll.signatories" :key="s">
                            {{ signatory.name }} <br>
                        </span>
                    </td>
                    <td v-show="columns[6].visibility">{{ payroll.user }}</td>
                    <td v-show="columns[7].visibility">
                        <a :href="'/payrolls/pdf/' + payroll.id" target="_blank" class="btn btn-primary btn-sm" >View</a>
                    </td>
                </tr>
                <tr v-if="filteredQueues.length == 0 && !loading">
                    <td colspan="5" class="text-center" >
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
                <span>{{ payrolls.length }} Manager Check(s)</span>
            </div>
        </div>


    </div>
</template>
<script>

import moment from 'moment';
import VueContentPlaceholders from 'vue-content-placeholders';

export default {

    components: {
        VueContentPlaceholders,
    },

    data() {
        return {
            loading: false,
            payrolls: [],
            companies: [],
            date: moment().format('YYYY-MM-DD'),
            currentPage: 0,
            itemsPerPage: 5,
            companySearch: '',
            typeSearch:'',
            columns: [
                {
                    name: 'Reference #',
                    visibility: true
                },
                {
                    name: 'Payroll Type',
                    visibility: true
                },
                {
                    name: 'Company',
                    visibility: true
                },
                {
                    name: 'Manager',
                    visibility: true
                },
                {
                    name: 'Applicants',
                    visibility: true
                },
                {
                    name: 'Signatories',
                    visibility: false
                },
                {
                    name: 'Submitted By',
                    visibility: false
                },
                {
                    name: 'PDF',
                    visibility: true
                }
            ],
        }
    },

    mounted() {
        var options = [];
        $( '.dropdown-menu button' ).on( 'click', function( event ) {
        var $target = $( event.currentTarget ),
            val = $target.attr( 'data-value' ),
            $inp = $target.find( 'input' ),
            idx;
        if ( ( idx = options.indexOf( val ) ) > -1 ) {
            options.splice( idx, 1 );
            setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
        } else {
            options.push( val );
            setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
        }
        $( event.target ).blur();
        return false;
        });
    },

    created() {
        this.getPayrolls()
        this.getCompanies()
    },

    methods: {
        getPayrolls() {
            this.loading = true
            axios.get('/submittedPayroll/' + this.date)
            .then(response => {
                this.payrolls = response.data
                this.loading = false
            });        
        },

        setVisibility(column) {
            column.visibility = !column.visibility
        },

        getCompanies() {
            axios.get('/getCompanies')
            .then(response => this.companies = response.data);
        },

        money(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

        searchDate(date) {
            return moment(date).format('YYYY-MM-DD');
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
        filteredEntries() {
            return this.payrolls.filter(item => {
                return item.company.toLowerCase().includes(this.companySearch.toLowerCase()) &&
                       item.type.toLowerCase().includes(this.typeSearch.toLowerCase());
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
    },

    watch: {
        date() {
          return this.getPayrolls();
        }
    }


    
}
</script>
<style scoped>
    .dropdown-menu button {
        cursor: pointer;
    }

    .column-items {
        display: flex;
        align-items: center;
    }

</style>
