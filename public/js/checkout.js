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

        const inputs = fieldsEl.querySelectorAll('input');
        inputs.forEach(function (input) {
            clearFieldError(input);
        });
    }

    function toggleBillingSection() {
        if (!sameAsShipping || !billingContent) return;

        const hideBilling = sameAsShipping.checked;
        billingContent.style.display = hideBilling ? 'none' : 'block';

        if (hideBilling) {
            setAddressFieldsRequired(billingFields, false);

            const inputs = billingFields.querySelectorAll('input');
            inputs.forEach(function (input) {
                clearFieldError(input);
            });
        } else if (billingSelect) {
            toggleAddressFields(billingSelect, billingFields);
        }
    }

    function luhnCheck(cardNumber) {
        let sum = 0;
        let shouldDouble = false;

        for (let i = cardNumber.length - 1; i >= 0; i--) {
            let digit = parseInt(cardNumber.charAt(i), 10);

            if (shouldDouble) {
                digit *= 2;
                if (digit > 9) digit -= 9;
            }

            sum += digit;
            shouldDouble = !shouldDouble;
        }

        return sum % 10 === 0;
    }

    function isValidExpiry(value) {
        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(value)) {
            return false;
        }

        const [monthStr, yearStr] = value.split('/');
        const month = parseInt(monthStr, 10);
        const year = 2000 + parseInt(yearStr, 10);

        const now = new Date();
        const expiryDate = new Date(year, month, 0, 23, 59, 59);

        return expiryDate >= now;
    }

    function isValidPostcode(value) {
        const trimmed = value.trim().toUpperCase();
        return /^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/.test(trimmed);
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

        field.addEventListener('input', function () {
            clearFieldError(field);
        });
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
            clearFieldError(this);
        });
    }

    if (expiryInput) {
        expiryInput.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '').substring(0, 4);

            if (value.length >= 3) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }

            this.value = value;
            clearFieldError(this);
        });
    }

    if (cvvInput) {
        cvvInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, 4);
            clearFieldError(this);
        });
    }

    attachLiveValidationClear(nameInput);
    attachLiveValidationClear(emailInput);
    attachLiveValidationClear(shippingStreet);
    attachLiveValidationClear(shippingCity);
    attachLiveValidationClear(shippingCounty);
    attachLiveValidationClear(shippingPostCode);
    attachLiveValidationClear(billingStreet);
    attachLiveValidationClear(billingCity);
    attachLiveValidationClear(billingCounty);
    attachLiveValidationClear(billingPostCode);

    if (form) {
        form.addEventListener('submit', function (event) {
            let valid = true;

            const cardNumber = cardInput ? cardInput.value.replace(/\s/g, '') : '';
            const expiry = expiryInput ? expiryInput.value.trim() : '';
            const cvv = cvvInput ? cvvInput.value.trim() : '';
            const cardholderName = nameInput ? nameInput.value.trim() : '';

            clearFieldError(nameInput);
            clearFieldError(emailInput);
            clearFieldError(cardInput);
            clearFieldError(expiryInput);
            clearFieldError(cvvInput);

            if (!/^[A-Za-zÀ-ÿ' -]{2,100}$/.test(cardholderName)) {
                markFieldError(nameInput, 'Enter a valid full name.');
                valid = false;
            }

            if (!emailInput || !emailInput.checkValidity()) {
                markFieldError(emailInput, 'Enter a valid email address.');
                valid = false;
            }

            if (!/^\d{16}$/.test(cardNumber)) {
                markFieldError(cardInput, 'Card number must be 16 digits.');
                valid = false;
            } else if (!luhnCheck(cardNumber)) {
                markFieldError(cardInput, 'Enter a valid card number.');
                valid = false;
            }

            if (!isValidExpiry(expiry)) {
                markFieldError(expiryInput, 'Enter a valid expiry date that is not in the past.');
                valid = false;
            }

            if (!/^\d{3,4}$/.test(cvv)) {
                markFieldError(cvvInput, 'CVV must be 3 or 4 digits.');
                valid = false;
            }

            if (shippingSelect && shippingSelect.value === '') {
                const shippingValid = validateAddressFields({
                    street: shippingStreet,
                    city: shippingCity,
                    county: shippingCounty,
                    postCode: shippingPostCode
                }, 'Shipping');

                if (!shippingValid) {
                    valid = false;
                }
            }

            if (
                sameAsShipping &&
                !sameAsShipping.checked &&
                billingSelect &&
                billingSelect.value === ''
            ) {
                const billingValid = validateAddressFields({
                    street: billingStreet,
                    city: billingCity,
                    county: billingCounty,
                    postCode: billingPostCode
                }, 'Billing');

                if (!billingValid) {
                    valid = false;
                }
            }

            if (!valid) {
                event.preventDefault();
                form.reportValidity();

                const firstError = form.querySelector('.input-error');
                if (firstError) {
                    firstError.focus();
                }
            }
        });
    }
});