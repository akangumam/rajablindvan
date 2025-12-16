
    <!-- Currency Formatting Script -->
    <script>
        // Helper functions
        window.formatCurrency = function(value, isInput = false) {
            if (!value && value !== 0) return '';
            let str = value.toString();

            if (!isInput) {
                // Initial load: logic to convert SQL float to ID format
                // If it looks like a standard float (dot decimal, no comma), convert dot to comma
                if (str.indexOf('.') !== -1 && str.indexOf(',') === -1) {
                    str = str.replace('.', ',');
                }
            } else {
                // Input event: User is typing.
                // Dots are thousands separators. Remove them.
                str = str.replace(/\./g, '');
            }

            // Split integer and decimal parts
            let parts = str.split(',');
            let integerPart = parts[0].replace(/\D/g, ''); // Keep only digits
            let decimalPart = parts.length > 1 ? ',' + parts[1].replace(/\D/g, '') : '';

            // Format integer part with thousands separator (dot)
            if (integerPart) {
                integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            return integerPart + decimalPart;
        };

        window.parseCurrency = function(value) {
            if (!value) return 0;
            // Remove dots (thousands), replace comma with dot (decimal)
            let clean = value.toString().replace(/\./g, '').replace(',', '.');
            return parseFloat(clean) || 0;
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize formatting for all currency inputs
            const currencyInputs = document.querySelectorAll('.currency-input');

            currencyInputs.forEach(input => {
                // Initial format
                if (input.value) {
                    input.value = formatCurrency(input.value, false);
                }

                // Input listener
                input.addEventListener('input', function(e) {
                    let cursorPosition = this.selectionStart;
                    let oldLen = this.value.length;

                    let originalVal = this.value;
                    // Pass true to indicate this is user input
                    let formatted = formatCurrency(originalVal, true);

                    if (originalVal !== formatted) {
                        this.value = formatted;

                        // Attempt to preserve cursor position logic (basic)
                        let newLen = formatted.length;
                        let newPos = cursorPosition + (newLen - oldLen);
                        if (newPos < 0) newPos = 0;
                        this.setSelectionRange(newPos, newPos);
                    }
                });
            });

            // Clean up on form submit
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const inputs = this.querySelectorAll('.currency-input');
                    inputs.forEach(input => {
                        // We set the value to the cleaner parsed format (standard float)
                        // This allows backend validation 'numeric' to pass (if it accepts standard float)
                        // WARNING: standard 'numeric' rule in Laravel might reject '1000.5' if checking integer?
                        // Actually 'numeric' accepts floats.
                        input.value = parseCurrency(input.value);
                    });
                });
            });
        });
    </script>
