<template>
    <div>
        <v-row>
            <v-dialog :value="getDeleteModalObj.showDeleteDialog" max-width="290">
                <v-card>
                    <v-card-title class="text-h6">
                        {{getDeleteModalObj.msg}}
                    </v-card-title>
                    <v-card-text
                        >Action cannot be undone!</v-card-text
                    >
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="grey"
                            class="white--text"
                            @click="closeDialog"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            color="red darken-1"
                            class="white--text"
                            @click="deleteRow"
                        >
                            Delete
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return{
            isDeleting: false,
        }
    },
    methods: {
        async deleteRow() {

            this.isDeleting = true;
            const res = await this.callApi(
                "post",
                this.getDeleteModalObj.deleteUrl,
                this.getDeleteModalObj.data
            );
            if (res.status === 200) {
                this.successMsg(this.getDeleteModalObj.successMsg);
                this.$store.commit('setDeleteModal', true)

            } else {
                this.swrMsg();
                this.$store.commit('setDeleteModal', false)
                
            }
            this.isDeleting = false;
        },
        closeDialog() {
            this.$store.commit('setDeleteModal', false)
        }
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    }
}
</script>
