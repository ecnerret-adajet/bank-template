<template>
    <div>

        <p>Payees Table</p>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                <th scope="col">Payee</th>
                <th scope="col">Nature</th>
                <th scope="col">Reference Number</th>
                <th scope="col">Amount</th>
                <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
        <tr v-for="(payee, index) in payees" :key="index">
            <td>
                <div v-if="payee.status == 0" @dblclick="editItem(payee)">{{ payee.name }}</div>
                <input v-else type="text" class="form-control" v-model="payee.name" v-focus>
            </td>
            <td>
                <div v-if="payee.status == 0" @dblclick="editItem(payee)">{{ payee.nature }}</div>
                <input v-else type="text" class="form-control"  v-model="payee.nature" v-focus>
            </td>
            <td>
                <div v-if="payee.status == 0" @dblclick="editItem(payee)">{{ payee.ref_num }}</div>
                <input v-else type="number" class="form-control" v-model="payee.ref_num" v-focus>
            </td>
            <td>
                <div v-if="payee.status == 0" @dblclick="editItem(payee)">{{ payee.amount }}</div>
                <input v-else type="number" class="form-control" v-model="payee.amount" v-focus>
            </td>
            <td>
                 <button v-if="payee.status == 0" type="button" class="btn btn-primary btn-block" @click="removeItem(payee)">Delete</button>
                 <button v-else type="button" class="btn btn-primary btn-block" @click="updateItem(payee)">Update</button>
            </td>
        </tr>
        
        <tr>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control" id="name" v-model="name" placeholder="Enter Name">
                </div>
            </td>
            <td>
                 <div class="form-group">
                    <input type="text" class="form-control" id="nature" v-model="nature" placeholder="Enter Nature">
                </div>
            </td>
            <td>
                 <div class="form-group">
                    <input type="number" class="form-control" id="ref_number" v-model="ref_num" placeholder="Enter Reference Number">
                </div>
            </td>
             <td>
                 <div class="form-group">
                    <input type="number" class="form-control" id="amount" v-model="amount" placeholder="Enter Amount">
                </div>
            </td>
            <td>
                <button type="button"  class="btn btn-primary btn-block" :disabled="!allowToSubmit" @click.prevent="addItem">Add</button>
            </td>
        </tr>
         </tbody>
    </table> 


    <div class="row mt-3">
        <div class="col">
            <div class="form-group text-right">
            <label>MC Cost:</label>
            <input type="number" class="form-control w-25 ml-auto" id="grand-total" name="mc_cost" v-model="mc_cost" placeholder="MC Cost">
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="form-group text-right">
            <label>Grand Total:</label>
            <input type="number" class="form-control w-25 ml-auto" id="grand-total"  name="grand_total" v-model="grandTotal" placeholder="Grand Total">
            </div>
        </div>
    </div>


    </div>
</template>
<script>
export default {
    props: ['user_id'],
    data() {
        return {
            name: '',
            nature: '',
            ref_num: '',
            amount: '',
            mc_cost: '',
            payees: [],
            beforeEditCache: {
                name: '',
                nature: '',
                ref_num: '',
                amount: ''
            },
        }
    },

     directives: {
        focus: {
            // directive definition
            inserted: function(el) {
                el.focus()
            }
        }
    },

    created() {
        this.getPayee();
    },

    methods: {

        getPayee() {
            axios.get('/payees')
            .then(response => this.payees = response.data);
        },

        resetFields() {
            // reset fields
            this.name = ''
            this.nature = ''
            this.ref_num = ''
            this.amount = ''
        },

        addItem() {

            axios.post('/payees/' + this.user_id , {
                name: this.name, 
                nature: this.nature,
                ref_num: this.ref_num,
                amount: this.amount,
                status: 0,
            })
            .then(response => {
                console.log(response.data);
                this.payees.push(response.data);
            })
            .catch((error) => {
                console.log(error);
            });

            this.resetFields();

        },

        editItem(payee) {
            axios.put('/payees/' + payee.id)
            .then(response => {
                console.log(response.data);
                this.beforeEditCache.name = payee.name;
                this.beforeEditCache.nature = payee.nature;
                this.beforeEditCache.ref_num = payee.ref_num;
                this.beforeEditCache.amount = payee.amount;
            }).catch((error) => {
                console.log(error);
            });
        },

        updateItem(payee) {
            if(payee.name.trim().length == 0) {
                payee.name = this.beforeEditCache.name;
            }

            if(payee.nature.trim().length == 0) {
                payee.nature = this.beforeEditCache.nature;
            }

            if(payee.ref_num.length == 0) {
                payee.ref_num = this.beforeEditCache.ref_num;
            }

            if(payee.amount.length == 0) {
                payee.amount = this.beforeEditCache.amount;
            }

             payee.editing = false;
        },

        removeItem(payee) {

            axios.delete('/payees/' + payee.id)
            .then(response => {
                this.payees.splice(this.payees.indexOf(payee), 1)
            })
            .catch((error) => {
                console.log(error);
            });

        } 
    },

    computed: {
        allowToSubmit() {
            return this.name.trim().length > 0 &&
                   this.nature.trim().length > 0 &&
                   this.ref_num.trim().length > 0 &&
                   this.amount.trim().length > 0;
        },

        grandTotal() {
            var finalTotal = 0, payeeTotal;
            payeeTotal = this.payees.reduce((total ,payee) => total + Number(payee.amount), 0);
            finalTotal = payeeTotal + Number(this.mc_cost);
            return finalTotal;
        }
    }
    
}
</script>
