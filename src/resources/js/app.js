window.toggleHandler = function() {
    return {
        checked: [],
        toggleCheck (detail) {
            return (detail.value) ? this.addItem(detail.id) : this.removeItem(detail.id);
        },
        addItem (id) {
            let index = this.checked.indexOf(id);
            if (index === -1) {
                this.checked.push(id)
            }
        },
        removeItem (id) {
            let index = this.checked.indexOf(id);
            if (index !== -1) {
                this.checked.splice(index, 1);
            }
        }
    }
};
