<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on, attrs }">
            <div v-if="noteResult == null" v-bind="attrs" v-on="on" color="green">
            <v-icon v-if="noteResult == null" v-bind="attrs" v-on="on" color="green">add</v-icon>Add A Note</div>

        </template>
        <v-card>
            <v-card-title>
                <span class="headline">Add A Note</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="noteContent"
                                label="Enter Your Note"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialog = false"
                    >Close</v-btn
                >
                <v-btn color="blue darken-1" text @click="saveNote">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import NoteMixin from "../mixins/NoteMixin.js";
export default {
    props: {
        note: Object,
        id: Number
    },
    data: () => ({
        dialog: false,
        noteContent: ""
    }),
    mixins: [NoteMixin],
    computed: {
        noteResult() {
            return this.getNote(this.note);
        }
    },

    methods: {
        saveNote() {
            axios
                .post(`http://127.0.0.1:8000/api/issues/note/${this.id}`, {
                    note: this.noteContent
                })
                .then(response => {
                    this.$emit("savedNote");
                    console.log(response.data);
                    this.dialog = false;
                });
        }
    }
};
</script>
