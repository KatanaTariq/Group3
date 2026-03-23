document.addEventListener('DOMContentLoaded', function () {
    const sameAsShipping = document.getElementById('same_as_shipping');
    const billingContent = document.getElementById('billing-section-content');

    const shippingSelect = document.getElementById('shipping_address_id');
    const shippingFields = document.getElementById('shipping-address-fields');

    const billingSelect = document.getElementById('billing_address_id');
    const billingFields = document.getElementById('billing-address-fields');

    const cardInput = document.getElementById('card');
    const expiryInput = document.getElementById('expiry');
    const cvvInput = document.getElementById('cvv');

    function toggleBillingSection() {
        if (!sameAsShipping || !billingContent) return;

        billingContent.style.display = sameAsShipping.checked ? 'none' : 'block';
    }

    function toggleAddressFields(selectEl, fieldsEl) {
        if (!selectEl || !fieldsEl) return;

        fieldsEl.style.display = selectEl.value ? 'none' : 'block';
    }

    if (sameAsShipping) {
        sameAsShipping.addEventListener('change', toggleBillingSection);
        toggleBillingSection();
    }

    if (shippingSelect) {
        shippingSelect.addEventListener('change', function () {
            toggleAddressFields(shippingSelect, shippingFields);
        });
        toggleAddressFields(shippingSelect, shippingFields);
    }

    if (billingSelect) {
        billingSelect.addEventListener('change', function () {
            toggleAddressFields(billingSelect, billingFields);
        });
        toggleAddressFields(billingSelect, billingFields);
    }

    if (cardInput) {
        cardInput.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '').substring(0, 16);
            value = value.replace(/(.{4})/g, '$1 ').trim();
            this.value = value;
        });
    }

    if (expiryInput) {
        expiryInput.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '').substring(0, 4);

            if (value.length >= 3) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }

            this.value = value;
        });
    }

    if (cvvInput) {
        cvvInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, 4);
        });
    }
});