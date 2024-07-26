document.addEventListener('DOMContentLoaded', function () {
	const expiryMonthSelect = document.getElementById('expiryMonth');
	const expiryYearSelect = document.getElementById('expiryYear');
	const currentYear = new Date().getFullYear();
	const currentMonth = new Date().getMonth() + 1;

	function populateMonthSelect() {
		expiryMonthSelect.innerHTML = '';
		for (let i = 1; i <= 12; i++) {
			const option = document.createElement('option');
			option.value = i < 10 ? `0${i}` : i;
			option.textContent = i < 10 ? `0${i}` : i;
			expiryMonthSelect.appendChild(option);
		}
		expiryMonthSelect.value = currentMonth < 10 ? `0${currentMonth}` : currentMonth;
	}

	function populateYearSelect() {
		expiryYearSelect.innerHTML = '';
		for (let i = currentYear; i <= currentYear + 20; i++) {
			const option = document.createElement('option');
			option.value = i;
			option.textContent = i;
			expiryYearSelect.appendChild(option);
		}
		expiryYearSelect.value = currentYear;
	}

	populateMonthSelect();
	populateYearSelect();

	expiryYearSelect.addEventListener('change', validateExpiryDate);
	expiryMonthSelect.addEventListener('change', validateExpiryDate);

	function validateExpiryDate() {
		const selectedMonth = parseInt(expiryMonthSelect.value, 10);
		const selectedYear = parseInt(expiryYearSelect.value, 10);

		if (selectedYear === currentYear && selectedMonth < currentMonth) {
			expiryMonthSelect.value = '';
			alert('The expiry month cannot be in the past.');
		}
	}

	const form = document.getElementById('creditCardForm');
	form.addEventListener('submit', function (event) {
		event.preventDefault();
		const formData = new FormData(form);

		fetch('process.php', {
			method: 'POST',
			body: formData
		})
			.then(response => response.text())
			.then(data => {
				const errorDiv = document.getElementById('errorMessages');
				if (data.includes('Form submitted successfully!')) {
					errorDiv.style.display = 'none';
					alert('Form submitted successfully!');
					form.reset();
					populateMonthSelect();
					populateYearSelect();
				} else {
					errorDiv.style.display = 'block';
					errorDiv.innerHTML = data;
				}
			})
			.catch(error => console.error('Error:', error));
	});

	function restrictInputToDigits(event) {
		const input = event.target;
		input.value = input.value.replace(/\D/g, '');
	}

	function formatCardNumber(event) {
		const input = event.target;
		let value = input.value.replace(/\D/g, '').substring(0, 16);
		const parts = [];
		for (let i = 0; i < value.length; i += 4) {
			parts.push(value.substring(i, i + 4));
		}
		input.value = parts.join(' ');
	}

	const cardNumberInput = document.getElementById('cardNumber');
	const cvvInput = document.getElementById('cvv');

	cardNumberInput.addEventListener('input', restrictInputToDigits);
	cardNumberInput.addEventListener('input', formatCardNumber);
	cvvInput.addEventListener('input', restrictInputToDigits);
});