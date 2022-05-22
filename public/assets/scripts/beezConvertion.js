document.addEventListener('DOMContentLoaded', () => {
    amountInput = document.querySelector('#amount')
    convertionValue = document.querySelector('#convertion')

    amountInput.addEventListener('input', () => {
        convertedValue = (parseFloat(amountInput.value) * 3.33)/100
        console.log((parseFloat(amountInput.value) * 3.33).toFixed(2), parseFloat(amountInput.value))

        if (isNaN(convertedValue) === false) {
            convertionValue.textContent = convertedValue.toFixed(2) + '€'
        } else {
            convertionValue.textContent = '...€'
        }
    })
})