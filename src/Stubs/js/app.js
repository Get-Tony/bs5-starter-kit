// BS5 Starter Kit - Main JavaScript Entry Point
// Bootstrap 5 Toolkit

import './bootstrap';

// Import Bootstrap JavaScript (all components)
import * as bootstrap from 'bootstrap';

// Make Bootstrap available globally (for manual usage)
window.bootstrap = bootstrap;

// BS5 Kit Utilities
window.BS5Kit = {
    // Toast notifications using Bootstrap
    toast(message, type = 'info') {
        const toastContainer = document.getElementById('toast-container') || this.createToastContainer();
        const toast = this.createToastElement(message, type);
        toastContainer.appendChild(toast);

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        // Remove toast element after it's hidden
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    },

    createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    },

    createToastElement(message, type) {
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-' + this.getBootstrapType(type) + ' border-0';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        return toast;
    },

    getBootstrapType(type) {
        const typeMap = {
            'info': 'primary',
            'success': 'success',
            'warning': 'warning',
            'error': 'danger',
            'danger': 'danger'
        };
        return typeMap[type] || 'primary';
    },

    // Confirm dialog using Bootstrap modal
    confirm(message, title = 'Confirm') {
        return new Promise((resolve) => {
            const modal = this.createConfirmModal(message, title, resolve);
            document.body.appendChild(modal);

            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();

            modal.addEventListener('hidden.bs.modal', () => {
                modal.remove();
            });
        });
    },

    createConfirmModal(message, title, resolve) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-action="cancel">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-action="confirm">Confirm</button>
                    </div>
                </div>
            </div>
        `;

        modal.addEventListener('click', (e) => {
            if (e.target.dataset.action === 'confirm') {
                resolve(true);
            } else if (e.target.dataset.action === 'cancel') {
                resolve(false);
            }
        });

        return modal;
    }
};

// Pure Bootstrap interactions for enhanced functionality
document.addEventListener('DOMContentLoaded', function() {
    // Auto-initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});
