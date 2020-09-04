export default {
    methods: {
        getNote(note) {
            if (!note) return null;
            return note.note;
        }
    }
};
