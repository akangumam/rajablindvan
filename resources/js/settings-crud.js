/**
 * Generic CRUD functions for Settings pages
 * Can be used for any simple entity (locations, service-types, expense-types, etc)
 */

class SettingsCRUD {
    constructor(config) {
        this.entityName = config.entityName; // e.g., 'location', 'service-type'
        this.routePrefix = config.routePrefix; // e.g., 'settings.locations'
        this.modalId = config.modalId; // e.g., 'placeModal'
        this.formFields = config.formFields || ['name', 'description'];
        this.isEditMode = false;
    }

    openAddModal() {
        this.isEditMode = false;
        document.getElementById('modalTitle').textContent = `Add New ${this.entityName}`;
        document.getElementById(`${this.modalId}_id`).value = '';
        
        this.formFields.forEach(field => {
            const element = document.getElementById(`${this.modalId}_${field}`);
            if (element) element.value = '';
        });
        
        document.getElementById(this.modalId).classList.add('show');
    }

    openEditModal(id, data) {
        this.isEditMode = true;
        document.getElementById('modalTitle').textContent = `Edit ${this.entityName}`;
        document.getElementById(`${this.modalId}_id`).value = id;
        
        Object.keys(data).forEach(key => {
            const element = document.getElementById(`${this.modalId}_${key}`);
            if (element) element.value = data[key] || '';
        });
        
        document.getElementById(this.modalId).classList.add('show');
    }

    closeModal() {
        document.getElementById(this.modalId).classList.remove('show');
    }

    async save(storeRoute, updateRoute, csrfToken) {
        const id = document.getElementById(`${this.modalId}_id`).value;
        const formData = {};
        
        this.formFields.forEach(field => {
            const element = document.getElementById(`${this.modalId}_${field}`);
            if (element) formData[field] = element.value.trim();
        });
        
        // Basic validation
        if (!formData.name) {
            alert('Please enter a name');
            return;
        }

        const url = this.isEditMode 
            ? updateRoute.replace(':id', id)
            : storeRoute;
        
        const method = this.isEditMode ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();
            
            if (data.success) {
                alert(data.message);
                this.closeModal();
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to save. Please try again.');
        }
    }

    async delete(id, name, deleteRoute, csrfToken) {
        if (confirm(`Are you sure you want to delete "${name}"?`)) {
            try {
                const response = await fetch(deleteRoute.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to delete. Please try again.');
            }
        }
    }

    initModalCloseOnOutsideClick() {
        window.onclick = (event) => {
            const modal = document.getElementById(this.modalId);
            if (event.target == modal) {
                this.closeModal();
            }
        };
    }
}

// Export for use in blade templates
window.SettingsCRUD = SettingsCRUD;
