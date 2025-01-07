console.log(ceanPhoneCountryDropdown);
let countries = ceanPhoneCountryDropdown.countryCode;
let selectedCurrentCountryCode = ceanPhoneCountryDropdown.defaultCountryCode.toLowerCase();

// Make sure DOM is ready
document.addEventListener('DOMContentLoaded', function () {
    const dropdownButton = document.getElementById('cean_countryDropdown');
    const dropdownMenu = document.getElementById('cean_dropdownMenu');
    const selectedFlag = document.getElementById('cean_selectedFlag');
    const selectedCode = document.getElementById('cean_selectedCode');
    const countryCodeInput = document.querySelector('[name="_cean_contact_country"]');

    // Function to monitor changes on selectedCurrentCountryCode
    let handler = {
        set(target, property, value) {
            if (property === 'code' && target[property] !== value) {
                // Remove the previous flag class
                const previousClass = `fi-${target[property]}`;
                selectedFlag.classList.remove(previousClass);

                // Add the new flag class
                const newClass = `fi-${value}`;
                selectedFlag.classList.add('fi', newClass);

                // Update the input field with the new value
                countryCodeInput.value = value.toLowerCase();
            }
            target[property] = value;
            return true;
        },
    };

    // Proxy to observe changes
    let selectedCountry = new Proxy({ code: selectedCurrentCountryCode }, handler);

    function populateDropdown() {
        let dropdownContent = [];
        for (let i in countries) {
            dropdownContent.push(`
                <button
                    class="flex w-full items-center px-4 py-2 text-sm bg-secondary-black"
                    data-code="${i}"
                    type="button"
                >
                    <span class="text-xl fi fi-${i.toLowerCase()}"></span>
                    <span class="mr-2">${countries[i]}</span>
                </button>
            `);
        }
        dropdownMenu.querySelector('div').innerHTML = dropdownContent.join('');
    }

    function setDefaultValues() {
        // Set default flag class
        selectedFlag.classList.add('fi', `fi-${selectedCurrentCountryCode}`);

        // Set default value for input field
        countryCodeInput.value = selectedCurrentCountryCode.toLowerCase();
        console.log(selectedCurrentCountryCode, countryCodeInput);
    }

    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    // Handle option selection
    dropdownMenu.addEventListener('click', (e) => {
        const button = e.target.closest('button');
        if (button) {
            const code = button.dataset.code;
            selectedCountry.code = code.toLowerCase(); // Update Proxy object
            dropdownMenu.classList.add('hidden');
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });

    // Initialize dropdown
    populateDropdown();

    // Set default values on load
    setDefaultValues();
});
