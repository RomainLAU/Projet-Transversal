document.addEventListener('DOMContentLoaded', () => {
    
    let filter = document.querySelector('#dark-background')
    let popupButton = document.querySelector('.popupButton')
    let closingCross = document.querySelector('#cross')

    popupButton.addEventListener('click', (event) => {
        event.preventDefault()
        filter.style.display = 'block'
    })

    closingCross.addEventListener('click', () => {
        filter.style.display = 'none'
    })

   

})

