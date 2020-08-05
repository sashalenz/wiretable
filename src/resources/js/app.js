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

window.alert = function () {
    return {
        showAlert: false,
        status: '',
        message: '',
        description: '',
        show(event) {
            this.showAlert = true;
            this.status = event.status || 'info';
            this.message = event.message;
            this.description = event.description || '';
            setTimeout(() => this.showAlert = false, 5000);
        },
        hide() {
            this.showAlert = false;
            this.status = '';
            this.message = '';
            this.description = '';
        }
    }
};
