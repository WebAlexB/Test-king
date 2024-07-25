document.addEventListener('DOMContentLoaded', function () {
	const expiryMonthSelect = document.getElementById('expiryMonth');
	const expiryYearSelect = document.getElementById('expiryYear');
	const currentYear = new Date().getFullYear();

	for (let i = 1; i <= 12; i++) {
		const option = document.createElement('option');
		option.value = i < 10 ? `0${i}` : i;
		option.textContent = i < 10 ? `0${i}` : i;
		expiryMonthSelect.appendChild(option);
	}
	for (let i = currentYear; i <= currentYear + 20; i++) {
		const option = document.createElement('option');
		option.value = i;
		option.textContent = i;
		expiryYearSelect.appendChild(option);
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

	const cardNumberInput = document.getElementById('cardNumber');
	const cvvInput = document.getElementById('cvv');

	cardNumberInput.addEventListener('input', restrictInputToDigits);
	cvvInput.addEventListener('input', restrictInputToDigits);
});
