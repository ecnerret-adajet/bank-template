<template>
     <div class="modal fade" id="deleteBank" tabindex="-1" role="dialog" aria-labelledby="deleteBankLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBankLabel">Delete a bank</h5>
                <button type="button" class="close" @click="closeModal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure you want to delete this record ?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                <button type="button" class="btn btn-primary"  @click.prevent="deleteBank">Submit</button>
            </div>
            </div>
        </div>
        </div>
</template>
<script>
import Toasted from 'vue-toasted';

export default {

    props: ['toDelete','showModalDelete'],

    watch: {
        showModalDelete() {
            if(this.showModalDelete == true) {
                $('#deleteBank').modal('show')
            }
        }
    },

    methods: {

        returnMessage(message) {
            Vue.toasted.show(message, {
                theme: "primary",
                position: "bottom-right",
                duration : 5000
            });
        },

        closeModal() {
            $('#deleteBank').modal('hide')
            return this.$emit('returnShowModalDelete',false)
        },


        deleteBank() {
            axios.delete(`/banks/${this.toDelete.id}`)
            .then(response => {
                if(response.status === 200) {
                    return Promise.resolve(response.data)
                    .then(response => {
                        this.$emit('deleteResponse', response)
                        return response;
                    })
                    .then(() => {
                        this.returnMessage("Deleted Successfully!")
                        this.$emit('returnShowModalDelete', false)
                         $('#deleteBank').modal('hide')
                    })
                }
            })
            .catch(error => {
                this.returnMessage("Something went wrong, please refresh and try again")
            })
        },
    }

}
</script>

