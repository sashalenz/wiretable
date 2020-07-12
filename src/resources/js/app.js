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

window.modal = function() {
    return {
        state: 'CLOSED',
        html: '',
        open(url) {
            this.state = 'TRANSITION';
            fetch(url)
                .then(response => response.text())
                .then(data => this.html = data);
            
            setTimeout(() => { this.state = 'OPEN' }, 50)
        },
        close() {
            this.state = 'TRANSITION';
            this.html = '';
            setTimeout(() => { this.state = 'CLOSED' }, 300)
        },
        isOpen() { return this.state === 'OPEN' },
        isOpening() { return this.state !== 'CLOSED' },
    }
};
