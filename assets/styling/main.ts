const buttonMoreInformation : NodeListOf<HTMLDivElement> = document.querySelectorAll('[data-information="showMoreInformation"]')

/*buttonMoreInformation.forEach((button) => {
    button.addEventListener('mouseover', (e : Event) => {
        e.preventDefault()  
        let boxMessage = (e.target as Element).parentNode.querySelector('[data-information="boxMessage"]')
        boxMessage === null ? boxMessage = (e.target as Element).parentNode.parentNode.parentNode.querySelector('[data-information="boxMessage"]') : boxMessage = boxMessage
        
        boxMessage.classList.remove('hidden')
        boxMessage.classList.add('block')
        //console.log(boxMessage)
    })
})*/




console.log(buttonMoreInformation)