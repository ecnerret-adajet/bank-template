<template>
     <div class="modal fade" id="deleteManager" tabindex="-1" role="dialog" aria-labelledby="deleteManagerLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteManagerLabel">Delete a manager</h5>
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
                <button type="button" class="btn btn-primary"  @click.prevent="deleteManager">Submit</button>
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
                $('#deleteManager').modal('show')
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
            $('#deleteManager').modal('hide')
            return this.$emit('returnShowModalDelete',false)
        },


        deleteManager() {
            axios.delete(`/managers/${this.toDelete.id}`)
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
                         $('#deleteManager').modal('hide')
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

