<template>
    <div>

        <div class="row mb-2">
            <!-- <div class="col">
                <div class="form-group">
                    <label class="text-muted text-uppercase">Filter by week</label>
                    <input class="form-control" type="week">
                </div>
            </div> -->
            <div class="col">
                <div class="form-group">
                    <label class="text-muted text-uppercase" >Filter by date</label>
                    <input class="form-control" type="date" v-model="date" :max="currentDate">
                </div>
            </div>
            <div class="col-1">
                <label>&nbsp;</label>
                <div class="form-group">
                    <div class="btn-group">
                    <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-2x fa-filter" aria-hidden="true"></i>
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
                <tr v-for="(mcheckc, b) in filteredQueues" :key="b" v-if="!loading">
                    <td v-show="columns[0].visibility">{{ mcheckc.ref_num }}</td>
                    <td v-show="columns[1].visibility">{{ mcheckc.account_number }}</td>
                    <td v-show="columns[2].visibility">{{ mcheckc.company }}</td>
                    <td v-show="columns[3].visibility">PHP {{ money(mcheckc.mc_cost) }}</td>
                    <td v-show="columns[4].visibility">PHP {{ money(mcheckc.grand_total) }}</td>
                    <td v-show="columns[5].visibility">{{ mcheckc.manager }}</td>
                    <td v-show="columns[6].visibility">{{ mcheckc.payees.length }}</td>
                    <td v-show="columns[7].visibility">
                        <span v-for="(signatory, s) in mcheckc.signatories" :key="s">
                            {{ signatory.name }} <br>
                        </span>
                    </td>
                    <td v-show="columns[8].visibility">{{ mcheckc.user }}</td>
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
                                    <hr/>
                                    <content-placeholders-heading :img="true" />
                                    <content-placeholders-text :lines="1" />
                                    <hr/>
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
                <span>{{ manager_checks.length }} Manager Check(s)</span>
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
            manager_checks: [],
            companies: [],
            date: moment().format('YYYY-MM-DD'),
            currentPage: 0,
            itemsPerPage: 5,
            companySearch: '',
            columns: [
                {
                    name: 'Reference #',
                    visibility: true
                },
                {
                    name: 'Account #',
                    visibility: true
                },
                {
                    name: 'Company',
                    visibility: true
                },
                {
                    name: 'MC Cost',
                    visibility: true
                },
                {
                    name: 'Total',
                    visibility: true
                },
                {
                    name: 'Manager',
                    visibility: false
                },
                {
                    name: 'Payees',
                    visibility: false
                },
                {
                    name: 'Signatories',
                    visibility: false
                },
                {
                    name: 'Submitted By',
                    visibility: false
                },
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
        this.getManagerCheck()
        this.getCompanies()
    },

    methods: {
        getManagerCheck() {
            this.loading = true
            axios.get('/getManagerCheck/' + this.date)
            .then(response => {
                this.manager_checks = response.data
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
            return this.manager_checks.filter(item => {
                return item.company.toLowerCase().includes(this.companySearch.toLowerCase());
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
          return this.getManagerCheck();
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
