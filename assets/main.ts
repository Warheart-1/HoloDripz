const firstValitaionPassword = document.getElementById("registration_form_plainPassword_first") as HTMLInputElement
const secondValitaionPassword = document.getElementById("registration_form_plainPassword_second") as HTMLInputElement

const buttonSubmit = document.getElementsByClassName("btn")[0] as HTMLButtonElement

const accptTerms = document.getElementById("registration_form_agreeTerms") as HTMLInputElement

//Disable submit button
buttonSubmit.disabled = true

//Add event listener to input to check if password is valid
firstValitaionPassword.addEventListener('keyup', (e : KeyboardEvent) => {
    e.preventDefault()
    if(Number(firstValitaionPassword.value.length) < 8){
        firstValitaionPassword.style.border = "3px solid red"
        return
    }
    firstValitaionPassword.style.border = "3px solid green"
    secondValitaionPassword.focus()
})

//Add event listener to input to check if repeat password is valid and if it is the same as the first password
secondValitaionPassword.addEventListener('keyup', (e : KeyboardEvent) => {
    e.preventDefault()
    if(firstValitaionPassword.value !== secondValitaionPassword.value || Number(secondValitaionPassword.value.length) < 8 && Number(firstValitaionPassword.value.length) < 8){
        secondValitaionPassword.focus()
        secondValitaionPassword.style.border = "3px solid red"
        return
    }
    secondValitaionPassword.style.border = "3px solid green"
    if(!accptTerms.checked){
        accptTerms.focus()
        return
    }
    buttonSubmit.disabled = false
    buttonSubmit.focus()
})

//Variable to check if checkbox is checked
let isAccepted : boolean = false

//Add event listener to input to check if checkbox is checked
accptTerms.addEventListener('input', (e : Event) => {
    e.preventDefault()
    isAccepted = !isAccepted
    if(!isAccepted){
        buttonSubmit.disabled = true
        return
    }
    buttonSubmit.disabled = false
    buttonSubmit.focus()
})