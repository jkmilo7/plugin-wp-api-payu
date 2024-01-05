var Payment = function(){
	
	// Formularios
	var $formCreditcard = $("#creditcard-form");
	var $formPSE = $("#pse-form");
	var $formCash = $("#cash-form");
	var $formBanks = $("#banks-form");

	// Obtener la dirección IP
	var userIP;
	$.getJSON("https://api.ipify.org?format=json", function(data){
		userIP = data.ip;
	});

	var makePaymentRequest = function (url, formData, openUrl) {
		// Mostrar el indicador de carga
        showLoading();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData + '&ip=' + userIP,
            dataType: 'json',
            success: function (res) {                

                if (res.status === "ok") {

					showSuccessNotification("Procesando correctamente: " + res.message);

					if( res.message === "PENDING")
					{
						var nuevaReferencia = "555555555";
        				var mensaje = "En este momento su referencia de pago # " + nuevaReferencia + " presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidad financiera, por favor espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de atención al cliente 7429660 o enviar un correo electrónico a lina.caicedo@espacolaser.com.co y preguntar por el estado de la transacción: " + nuevaReferencia;

        				$('.pending-message').text(mensaje);
						$('.result-message-status-info').show();
						$('.result-message-status-success').hide();						
						$('.result-message-status-error').hide();
						$('.inline-button-back').attr('href', res.responseUrl);
						$('.inline-button-back').focus();
					}
					else
					{						
						$('.result-message-status-success').show();
						$('.result-message-status-info').hide();
						$('.result-message-status-error').hide();
						$('.inline-button-back').attr('href', res.responseUrl);
						$('.inline-button-back').focus();
					}

					if(openUrl)
					{
						// Abre una nueva pestaña con la URL proporcionada
						window.open(res.url, '_top');
					}					
                } else {
                    showErrorNotification("Error: " + res.message);
					$('.result-message-status-error').show();
					$('.result-message-status-success').hide();
					$('.result-message-status-info').hide();
					$('.inline-button-back').attr('href', res.responseUrl);
					$('.inline-button-back').focus();					
                }
            },
            error: function (res, a) {
				
	            showErrorNotification("Error: " + res.message);
				$('.result-message-status-error').show();
				$('.result-message-status-success').hide();
				$('.result-message-status-info').hide();

            },
            complete: function () {
                // Ocultar el indicador de carga cuando la petición esté completa (ya sea éxito o error)
                $('.box-errors-payment-method').show();
				hideLoading();				
            }
        });
    };
	return {
        creditcard: function () {

			var formElements = $formCreditcard[0].elements;		
			// Verificar la validez de los campos del formulario
			for (var i = 0; i < formElements.length; i++) {
				if (!formElements[i].checkValidity()) {
					// Mostrar el mensaje de error si el campo no es válido
					showErrorNotification("Faltan campos por digitar.")
					formElements[i].reportValidity();
					return; // Detener la ejecución si algún campo no es válido
				}
			}

			 // Validar número de teléfono			 
			 if (!validateCellPhone("creditcard_cell_phone")) {
				return; 
			}

			 // Validar número de cvv
			 if (!validateCVV) {
				 return; 
			 }

			 // Validar número de tarjeta de credito
			 if (!validateCreditCard) {
				return; 
			}

			// Validar nombre de la tarjeta de credito
			if (!validateOnlyText("creditcard_payer_name")) {
				return; 
			}

            var formData = $formCreditcard.serialize();
            makePaymentRequest('pay_gateway.php/creditcard-payment', formData, false);
        },
        pse: function (clickedButton) {
			var formElements = $formPSE[0].elements;		
			// Verificar la validez de los campos del formulario
			for (var i = 0; i < formElements.length; i++) {
				if (!formElements[i].checkValidity()) {
					// Mostrar el mensaje de error si el campo no es válido
					showErrorNotification("Faltan campos por digitar.")
					formElements[i].reportValidity();
					return; // Detener la ejecución si algún campo no es válido
				}
			}

			var selectedBankValue = document.getElementById("pse_bank").value;

            // Validar que se haya seleccionado una opción diferente de 0
            if (selectedBankValue === "0") {
				showInputError("pse_bank", "Selecciona el banco al que pertenece la cuenta bancaria");
                return;
            }

			var selectedTypePerson = document.getElementById("pse_type_person").value;

            // Validar que se haya seleccionado una opción diferente de 0
            if (selectedTypePerson === "") {
				showInputError("pse_type_person", "Selecciona el tipo de cliente titular de la cuenta bancaria.");
                return;
            }

			if (!validateOnlyText("pse_payer_name")) {
				return; 
			}

			if (!validateCellPhone("pse_cell_phone")) {
				return; 
			}

            var formData = $formPSE.serialize();
            makePaymentRequest('pay_gateway.php/pse-payment', formData, true);
			clickedButton.disabled = true;
        },
        cash: function () {
			var formElements = $formCash[0].elements;		
			// Verificar la validez de los campos del formulario
			for (var i = 0; i < formElements.length; i++) {
				if (!formElements[i].checkValidity()) {
					// Mostrar el mensaje de error si el campo no es válido
					formElements[i].reportValidity();
					return; // Detener la ejecución si algún campo no es válido
				}
			}
            var formData = $formCash.serialize();
            makePaymentRequest('pay_gateway.php/cash-payment', formData, true);
        },
        banks: function () {
			var formElements = $formBanks[0].elements;		
			// Verificar la validez de los campos del formulario
			for (var i = 0; i < formElements.length; i++) {
				if (!formElements[i].checkValidity()) {
					// Mostrar el mensaje de error si el campo no es válido
					formElements[i].reportValidity();
					return; // Detener la ejecución si algún campo no es válido
				}
			}
            var formData = $formBanks.serialize();
            makePaymentRequest('pay_gateway.php/banks-payment', formData, true);
        }
    };
}();

      
function validateOnlyText(inputId) {
    var text = document.getElementById(inputId).value;
    var regex = /^[a-zA-Z\s]+$/;

    if (!regex.test(text)) {
		showInputError(inputId, "Ingresa sólo texto, sin números ni caracteres especiales");        
        document.getElementById(inputId).focus();
        return false;
    }

	removeError(inputId);
    return true;
}

function validateOnlyNumber(inputId) {
	var text = document.getElementById(inputId).value;
	var regex = /^[0-9]+$/;

	if (!regex.test(text)) {
		showInputError(inputId, "Ingresa sólo números, sin texto ni caracteres especiales");
		document.getElementById(inputId).focus();
		return false;
	}

	removeError(inputId);
	return true;
}


function validateCreditCard() {

	var creditCardInput = document.getElementById('credit_card_number');
	var creditCardValue = creditCardInput.value.replace(/\s/g, ''); // Elimina espacios en blanco

	if (!isValidCreditCardNumber(creditCardValue)) {
		showInputError('credit_card_number', "Número de tarjeta inválido");		
		creditCardInput.focus();
		return false;        
    }

	removeError('credit_card_number');
	return true;
}

function validateCVV() {

	var cvvInput = document.getElementById('cvv');
	var cvvValue = cvvInput.value.replace(/\s/g, ''); // Elimina espacios en blanco

	if (!isValidCVV(cvvValue)) {
		showInputError('cvv', "El código de seguridad de la tarjeta de crédito debe ser de 3 dígitos");				
		cvvInput.focus();
		return false;
    }

	removeError('cvv');
	return true;
}

function validateCellPhone(inputId) {

	var cpInput = document.getElementById(inputId);
	var cpValue = cpInput.value.replace(/\s/g, ''); // Elimina espacios en blanco

	if (!isValidPhoneNumber(cpValue)) {
		showInputError(inputId, "Ingresa el número de teléfono valido del dueño de la tarjeta de crédito");		
		cpInput.focus();
		return false;
    }

	removeError(inputId);
	return true;
}

function isValidCreditCardNumber(cardNumber) {
	
	// Validación  basada en el algoritmo de Luhn:
	var sum = 0;
	var isSecondDigit = false;

	for (var i = cardNumber.length - 1; i >= 0; i--) {
		var digit = parseInt(cardNumber.charAt(i), 10);

		if (isSecondDigit) {
			digit *= 2;
			if (digit > 9) {
				digit -= 9;
			}
		}

		sum += digit;
		isSecondDigit = !isSecondDigit;
	}

	return sum % 10 === 0;
}

function isValidCVV(cvv) {	
	return /^[0-9]{3}$/.test(cvv);
}

function isValidPhoneNumber(phoneNumber) { 
    return /^[0-9]{10}$/.test(phoneNumber);
}

document.getElementById("creditcard_payer_name").addEventListener("blur", function() {
    validateOnlyText("creditcard_payer_name");
});

document.getElementById("credit_card_number").addEventListener("blur",  validateCreditCard);

document.getElementById("cvv").addEventListener("blur",  validateCVV);

document.getElementById("creditcard_cell_phone").addEventListener("blur", function() {
    validateCellPhone("creditcard_cell_phone");
});

document.getElementById("pse_payer_name").addEventListener("blur", function() {
    validateOnlyText("pse_payer_name");
});

document.getElementById("pse_cell_phone").addEventListener("blur", function() {
    validateCellPhone("pse_cell_phone");
});

function updatePaymentMethod(paymentMethod) {

	document.getElementById('creditcard_payment_method').value = paymentMethod;
}

function updatePaymentMethodCash(paymentMethod) {

	document.getElementById('payment_method_cash').value = paymentMethod;

	var cashInstructions = document.getElementById('cash-instructions');
	var efectyInstructions = document.getElementById('efecty-instructions');

	if (paymentMethod === 'EFECTY') {
		cashInstructions.style.display = 'none';
		efectyInstructions.style.display = 'block';
	} else {
		cashInstructions.style.display = 'block';
		efectyInstructions.style.display = 'none';
	}
}


function showInputError(inputId, errorMessage) {
    var inputElement = document.getElementById(inputId);
    var errorElementId = inputId + '_error';

    // Verifica si ya hay un mensaje de error y lo elimina
    var existingErrorElement = document.getElementById(errorElementId);
    if (existingErrorElement) {
        existingErrorElement.parentNode.removeChild(existingErrorElement);
    }

    // Crea un elemento de error y lo agrega después del campo de entrada
    var errorElement = document.createElement('span');
    errorElement.id = errorElementId;
    errorElement.className = 'error-message';
    errorElement.innerHTML = errorMessage;

    inputElement.parentNode.insertBefore(errorElement, inputElement.nextSibling);
}

function removeError(inputId) {
    var errorElementId = inputId + '_error';
    var existingErrorElement = document.getElementById(errorElementId);

    // Verifica si hay un mensaje de error y lo elimina
    if (existingErrorElement) {
        existingErrorElement.parentNode.removeChild(existingErrorElement);
    }
}

// Mostrar el indicador de carga
function showLoading() {
    $('#loading').show();
}

// Ocultar el indicador de carga
function hideLoading() {
    $('#loading').hide();
}

// Función para mostrar notificación de éxito
function showSuccessNotification(message) {
    toastr.success(message);
}

// Función para mostrar notificación de error
function showErrorNotification(message) {
    toastr.error(message);
}

function convertResponse(res)
{
	var responseText = res.responseText;

	// Busca el índice de la primera llave '{' para determinar el comienzo del JSON
	var jsonStartIndex = responseText.indexOf('{');

	// Extrae la porción de la cadena que contiene solo el JSON válido
	var jsonSubstring = responseText.substring(jsonStartIndex);

	return JSON.parse(jsonSubstring);
}