document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkoutForm');

    const sameAsShipping = document.getElementById('same_as_shipping');
    const billingContent = document.getElementById('billing-section-content');

    const shippingSelect = document.getElementById('shipping_address_id');
    const shippingFields = document.getElementById('shipping-address-fields');

    const billingSelect = document.getElementById('billing_address_id');
    const billingFields = document.getElementById('billing-address-fields');

    const cardInput = document.getElementById('card');
    const expiryInput = document.getElementById('expiry');
    const cvvInput = document.getElementById('cvv');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');

    const shippingStreet = document.getElementById('shipping_street');
    const shippingCity = document.getElementById('shipping_city');
    const shippingCounty = document.getElementById('shipping_county');
    const shippingPostCode = document.getElementById('shipping_post_code');

    const billingStreet = document.getElementById('billing_street');
    const billingCity = document.getElementById('billing_city');
    const billingCounty = document.getElementById('billing_county');
    const billingPostCode = document.getElementById('billing_post_code');

    function markFieldError(field, message) {
        if (!field) return;
        field.setCustomValidity(message);
        field.classList.add('input-error');
    }

    function clearFieldError(field) {
        if (!field) return;
        field.setCustomValidity('');
        field.classList.remove('input-error');
    }

    function setAddressFieldsRequired(fieldsEl, isRequired) {
        if (!fieldsEl) return;

        const inputs = fieldsEl.querySelectorAll('input');

        inputs.forEach(function (input) {
            if (input.id === 'shipping_county' || input.id === 'billing_county') {
                input.required = false;
            } else {
                input.required = isRequired;
            }
        });
    }

    function toggleAddressFields(selectEl, fieldsEl) {
        if (!selectEl || !fieldsEl) return;

        const usingSavedAddress = selectEl.value !== '';
        fieldsEl.style.display = usingSavedAddress ? 'none' : 'block';
        setAddressFieldsRequired(fieldsEl, !usingSavedAddress);

        fieldsEl.querySelectorAll('input').forEach(clearFieldError);
    }

    function toggleBillingSection() {
        if (!sameAsShipping || !billingContent) return;

        const hideBilling = sameAsShipping.checked;
        billingContent.style.display = hideBilling ? 'none' : 'block';

        if (hideBilling) {
            setAddressFieldsRequired(billingFields, false);
            billingFields.querySelectorAll('input').forEach(clearFieldError);
        } else if (billingSelect) {
            toggleAddressFields(billingSelect, billingFields);
        }
    }

    function isExpiryFormatValid(value) {
        return /^(0[1-9]|1[0-2])\/\d{2}$/.test(value);
    }

    function isValidExpiry(value) {
        if (!isExpiryFormatValid(value)) return false;

        const [monthStr, yearStr] = value.split('/');
        const inputMonth = parseInt(monthStr, 10);
        const inputYear = 2000 + parseInt(yearStr, 10);

        const now = new Date();
        const currentMonth = now.getMonth() + 1;
        const currentYear = now.getFullYear();

        if (inputYear < currentYear) return false;
        if (inputYear === currentYear && inputMonth < currentMonth) return false;

        return true;
    }

    function isValidPostcode(value) {
        return /^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/.test(value.trim().toUpperCase());
    }

    function isValidEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
    }

    function validateAddressFields(fields, prefix) {
        const { street, city, county, postCode } = fields;
        let isValid = true;

        clearFieldError(street);
        clearFieldError(city);
        clearFieldError(county);
        clearFieldError(postCode);

        if (!street.value.trim()) {
            markFieldError(street, `${prefix} street is required.`);
            isValid = false;
        } else if (street.value.trim().length > 120) {
            markFieldError(street, `${prefix} street must be 120 characters or fewer.`);
            isValid = false;
        }

        if (!city.value.trim()) {
            markFieldError(city, `${prefix} city is required.`);
            isValid = false;
        } else if (city.value.trim().length > 60) {
            markFieldError(city, `${prefix} city must be 60 characters or fewer.`);
            isValid = false;
        }

        if (county.value.trim().length > 60) {
            markFieldError(county, `${prefix} county must be 60 characters or fewer.`);
            isValid = false;
        }

        if (!postCode.value.trim()) {
            markFieldError(postCode, `${prefix} post code is required.`);
            isValid = false;
        } else if (!isValidPostcode(postCode.value)) {
            markFieldError(postCode, `Enter a valid ${prefix.toLowerCase()} post code.`);
            isValid = false;
        }

        return isValid;
    }

    function attachLiveValidationClear(field) {
        if (!field) return;
        field.addEventListener('input', () => clearFieldError(field));
    }

    // toggles
    sameAsShipping?.addEventListener('change', toggleBillingSection);
    toggleBillingSection();

    shippingSelect?.addEventListener('change', () => toggleAddressFields(shippingSelect, shippingFields));
    toggleAddressFields(shippingSelect, shippingFields);

    billingSelect?.addEventListener('change', () => toggleAddressFields(billingSelect, billingFields));
    toggleAddressFields(billingSelect, billingFields);

    // formatting
    cardInput?.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '').substring(0, 16);
        value = value.replace(/(.{4})/g, '$1 ').trim();
        this.value = value;
        clearFieldError(this);
    });

    expiryInput?.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '').substring(0, 4);
        if (value.length >= 3) value = value.slice(0, 2) + '/' + value.slice(2);
        this.value = value;
        clearFieldError(this);
    });

    cvvInput?.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').substring(0, 4);
        clearFieldError(this);
    });

    [
        nameInput, emailInput,
        shippingStreet, shippingCity, shippingCounty, shippingPostCode,
        billingStreet, billingCity, billingCounty, billingPostCode
    ].forEach(attachLiveValidationClear);

    // submit
    form?.addEventListener('submit', function (event) {
        let valid = true;

        const digitsOnly = cardInput?.value.replace(/\D/g, '') || '';
        const expiry = expiryInput?.value.trim() || '';
        const cvv = cvvInput?.value.trim() || '';
        const name = nameInput?.value.trim() || '';
        const email = emailInput?.value.trim() || '';

        [nameInput, emailInput, cardInput, expiryInput, cvvInput].forEach(clearFieldError);

        if (!/^[A-Za-zÀ-ÿ' -]{2,100}$/.test(name)) {
            markFieldError(nameInput, 'Enter a valid full name.');
            valid = false;
        }

        if (!isValidEmail(email)) {
            markFieldError(emailInput, 'Enter a valid email address.');
            valid = false;
        }

        if (digitsOnly.length !== 16) {
            markFieldError(cardInput, 'Card number must be exactly 16 digits.');
            valid = false;
        }

        if (!isExpiryFormatValid(expiry)) {
            markFieldError(expiryInput, 'Use MM/YY format (e.g. 03/27).');
            valid = false;
        } else if (!isValidExpiry(expiry)) {
            markFieldError(expiryInput, 'This card has expired.');
            valid = false;
        }

        if (!/^\d{3,4}$/.test(cvv)) {
            markFieldError(cvvInput, 'CVV must be 3 or 4 digits.');
            valid = false;
        }

        if (shippingSelect && shippingSelect.value === '') {
            if (!validateAddressFields({
                street: shippingStreet,
                city: shippingCity,
                county: shippingCounty,
                postCode: shippingPostCode
            }, 'Shipping')) valid = false;
        }

        if (!sameAsShipping.checked && billingSelect && billingSelect.value === '') {
            if (!validateAddressFields({
                street: billingStreet,
                city: billingCity,
                county: billingCounty,
                postCode: billingPostCode
            }, 'Billing')) valid = false;
        }

        if (!valid) {
            event.preventDefault();

            const firstError = form.querySelector('.input-error');
            if (firstError) {
                firstError.focus();
                firstError.reportValidity();
            }
        }
    });
});